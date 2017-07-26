<?php
//==============================================================================
// MailChimp Integration v201.2
// 
// Author: Clear Thinking, LLC
// E-mail: johnathan@getclearthinking.com
// Website: http://www.getclearthinking.com
// 
// All code within this file is copyright Clear Thinking, LLC.
// You may not copy or reuse code within this file without written permission.
//==============================================================================

class ControllerModuleMailchimpIntegration extends Controller {
	private $type = 'module';
	private $name = 'mailchimp_integration';
	
	public function index() {
		$data['type'] = $this->type;
		$data['name'] = $this->name;
		
		$data = array_merge($data, $this->load->language('account/address'));
		$data = array_merge($data, $this->load->language('account/edit'));
		$data['settings'] = $this->getSettings();
		$data['language'] = $this->session->data['language'];
		
		if (empty($data['settings']['status']) || empty($data['settings']['apikey']) || empty($data['settings']['listid'])) {
			return;
		}
		
		$data['email'] = $this->customer->getEmail();
		$data['subscribed'] = $this->customer->getNewsletter();
		$customer_group_id = (version_compare(VERSION, '2.0') < 0) ? $this->customer->getCustomerGroupId() : $this->customer->getGroupId();
		
		if (!empty($data['settings']['interest_groups'])
			&& file_exists(DIR_SYSTEM . 'library/mailchimp_integration_pro.php')
			&& (empty($data['settings']['display_routes']) || in_array($this->request->get['route'], explode(',', str_replace(array(' ', "\n", '%'), '', $data['settings']['display_routes']))))
		) {
			if (empty($this->session->data['mailchimp_interest_groups'])) {
				$this->load->library($this->name);
				$mailchimp_integration = new MailChimp_Integration($this->config, $this->db, $this->log, $this->session);
				
				$data['settings']['listid'] = $mailchimp_integration->determineList(array('customer_group_id' => $customer_group_id));
				$this->session->data['mailchimp_interest_groups'] = $mailchimp_integration->getInterestGroups($data['settings']['listid']);
				
				$member_info = $mailchimp_integration->getMemberInfo($data['settings']['listid'], $data['email']);
				$this->session->data['mailchimp_interests'] = array();
				if (!empty($member_info['merges']['GROUPINGS']) && $this->customer->isLogged()) {
					foreach ($member_info['merges']['GROUPINGS'] as $grouping) {
						foreach ($grouping['groups'] as $group) {
							if ($group['interested']) $this->session->data['mailchimp_interests'][$grouping['id']][] = $group['name'];
						}
					}
				}
			}
			$data['interest_groups'] = $this->session->data['mailchimp_interest_groups'];
			$data['interests'] = $this->session->data['mailchimp_interests'];
		} else {
			$data['interest_groups'] = array();
			$data['interests'] = array();
		}
		
		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();
		$data['country_id'] = $this->config->get('config_country_id');
		$data['zone_id'] = $this->config->get('config_zone_id');
		
		$template = (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/' . $this->type . '/' . $this->name . '.tpl')) ? $this->config->get('config_template') : 'default';
		$template_file = $template . '/template/' . $this->type . '/' . $this->name . '.tpl';
		
		if (version_compare(VERSION, '2.0') < 0) {
			$this->data = $data;
			$this->template = $template_file;
			$this->render();
		} else {
			return $this->load->view($template_file, $data);
		}
	}
	
	public function getZones() {
		$this->load->model('localisation/zone');
		$zones = $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']);
		echo json_encode($zones);
	}
	
	public function subscribe() {
		if (empty($this->request->post)) return;
		
		$customer_id = (int)$this->customer->getId();
		
		if ($customer_id) {
			$this->request->post['customer_id'] = $customer_id;
		}
		if (isset($this->request->post['address'])) {
			$this->request->post['address_1'] = $this->request->post['address'];
			unset($this->request->post['address']);
		}
		if (isset($this->request->post['country'])) {
			$this->request->post['country_id'] = $this->request->post['country'];
		}
		if (isset($this->request->post['zone'])) {
			$this->request->post['zone_id'] = $this->request->post['zone'];
		}
		
		$this->load->library($this->name);
		$mailchimp_integration = new MailChimp_Integration($this->config, $this->db, $this->log, $this->session);
		$data = array_merge($this->request->post, array('newsletter' => 1, 'update_existing' => (bool)$this->customer->isLogged()));
		$error = $mailchimp_integration->send($data);
		
		if ($error['code'] == 0 && $customer_id && !$this->customer->getNewsletter()) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = 1 WHERE customer_id = " . $customer_id);
		}
		
		echo json_encode($error);
	}
	
	public function webhook() {
		if (!isset($this->request->post['type']) || !isset($this->request->post['data']) || !isset($this->request->get['key'])) return;
		
		if ($this->request->get['key'] != $this->config->get('config_encryption')) {
			if ($this->config->get($this->name . '_testing_mode')) {
				$this->log->write(strtoupper($this->name) . ' WEBHOOK ERROR: webhook URL key ' . $this->request->get['key'] . ' does not match the store encryption key ' . $this->config->get('config_encryption') . ' for action "' . $this->request->post['type'] . '" for e-mail address ' . $this->request->post['data']['email']);
			}
			return;
		}
		
		$this->load->library('mailchimp_integration');
		$mailchimp_integration = new MailChimp_Integration($this->config, $this->db, $this->log, $this->session);
		$mailchimp_integration->webhook($this->request->post['type'], $this->request->post['data']);
	}
	
	//==============================================================================
	// Private functions
	//==============================================================================
	private function getSettings() {
		// custom, to work with list IDs and interest group IDs
		$settings = array();
		$settings_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `" . (version_compare(VERSION, '2.0.1') < 0 ? 'group' : 'code') . "` = '" . $this->db->escape($this->name) . "' ORDER BY `key` ASC");
		foreach ($settings_query->rows as $setting) {
			$value = (is_string($setting['value']) && strpos($setting['value'], 'a:') === 0) ? unserialize($setting['value']) : $setting['value'];
			$settings[str_replace($this->name . '_', '', $setting['key'])] = $value;
		}
		return $settings;
	}
}
?>