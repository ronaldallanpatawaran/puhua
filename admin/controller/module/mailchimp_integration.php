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
		$data = array(
			'type'				=> $this->type,
			'name'				=> $this->name,
			'autosave'			=> true,
			'settings_buttons'	=> false,
			'tooltips_button'	=> false,
			'permission'		=> $this->user->hasPermission('modify', $this->type . '/' . $this->name),
			'token'				=> $this->session->data['token'],
			'exit'				=> $this->url->link('extension/' . $this->type, 'token=' . $this->session->data['token'], 'SSL'),
		);
		
		$this->loadSettings($data);
		
		// Convert old settings
		$old_settings_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `key` = '" . $this->name . "_data'");
		if ($old_settings_query->num_rows) {
			foreach (unserialize($old_settings_query->row['value']) as $key => $value) {
				// extension-specific
				if ($key == 'webhooks') continue;
				// end
				if (is_array($value)) {
					if (is_int(key($value))) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `" . (version_compare(VERSION, '2.0.1') < 0 ? 'group' : 'code') . "` = '" . $this->name . "', `key` = '" . $this->name . "_" . $key . "', `value` = '" . implode(';', $value) . "'");
					} else {
						foreach ($value as $value_key => $value_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `" . (version_compare(VERSION, '2.0.1') < 0 ? 'group' : 'code') . "` = '" . $this->name . "', `key` = '" . $this->name . "_" . $key . "_" . $value_key . "', `value` = '" . $value_value . "'");
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `" . (version_compare(VERSION, '2.0.1') < 0 ? 'group' : 'code') . "` = '" . $this->name . "', `key` = '" . $this->name . "_" . $key . "', `value` = '" . $value . "'");
				}
			}
			$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `key` = '" . $this->name . "_data'");
		}
		
		// non-standard
		$this->load->library($this->name);
		$mailchimp_integration = new MailChimp_Integration($this->config, $this->db, $this->log, $this->session);
		$mailchimp_integration->addWebhooks();
		
		unset($this->session->data['mailchimp_interest_groups']);
		unset($this->session->data['mailchimp_interests']);
		// end
		
		//------------------------------------------------------------------------------
		// Data Arrays
		//------------------------------------------------------------------------------
		$data['currency_array'] = array($this->config->get('config_currency') => '');
		$this->load->model('localisation/currency');
		foreach ($this->model_localisation_currency->getCurrencies() as $currency) {
			$data['currency_array'][$currency['code']] = $currency['code'];
		}
		
		$data['customer_group_array'] = array(0 => $data['text_guests']);
		$this->load->model('sale/customer_group');
		foreach ($this->model_sale_customer_group->getCustomerGroups() as $customer_group) {
			$data['customer_group_array'][$customer_group['customer_group_id']] = $customer_group['name'];
		}
		
		$this->load->model('localisation/language');
		$data['language_array'] = array($this->config->get('config_language') => '');
		$data['language_flags'] = array();
		foreach ($this->model_localisation_language->getLanguages() as $language) {
			$data['language_array'][$language['code']] = $language['name'];
			$data['language_flags'][$language['code']] = $language['image'];
		}
		
		$data['store_array'] = array(0 => $this->config->get('config_name'));
		$store_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "store ORDER BY name");
		foreach ($store_query->rows as $store) {
			$data['store_array'][$store['store_id']] = $store['name'];
		}
		
		if (!empty($data['saved']['apikey'])) {
			$data['mailchimp_lists'] = array(0 => $data['standard_select']);
			foreach ($mailchimp_integration->getLists() as $list) {
				$data['mailchimp_lists'][$list['id']] = $list['name'];
			}
		}
		if (empty($data['saved']['apikey']) || !empty($data['mailchimp_lists']['error'])) {
			$data['mailchimp_lists'] = array(0 => $data['text_enter_an_api_key']);
		}
		
		//------------------------------------------------------------------------------
		// Extension Settings
		//------------------------------------------------------------------------------
		$data['settings'] = array();
		$data['settings'][] = array(
			'type'		=> 'tabs',
			'tabs'		=> array('extension_settings', 'list_settings', 'merge_tags', 'interest_groups', 'module_settings'),
		);
		$data['settings'][] = array(
			'key'		=> 'extension_settings',
			'type'		=> 'heading',
		);
		$data['settings'][] = array(
			'type'		=> 'html',
			'content'	=> '<div class="text-info text-center" style="padding-bottom: 20px">' . $data['help_extension_settings'] . '</div>',
		);
		$data['settings'][] = array(
			'key'		=> 'status',
			'type'		=> 'select',
			'options'	=> array('0' => $data['text_disabled'], '1' => $data['text_enabled']),
		);
		$data['settings'][] = array(
			'key'		=> 'testing_mode',
			'type'		=> 'select',
			'options'	=> array('0' => $data['text_disabled'], '1' => $data['text_enabled']),
		);
		$data['settings'][] = array(
			'key'		=> 'apikey',
			'type'		=> 'text',
			'attributes'=> array('style' => 'width: 300px !important'),
			'default'   => '0f3124574eacd50758b8e59f14b50b6d-us11',
		);
		$data['settings'][] = array(
			'key'		=> 'double_optin',
			'type'		=> 'select',
			'options'	=> array('0' => $data['text_disabled'], '1' => $data['text_enabled']),
			'default'	=> '1',
		);
		$data['settings'][] = array(
			'key'		=> 'webhooks',
			'type'		=> 'checkboxes',
			'options'	=> array(
				'subscribe'		=> $data['text_subscribes'],
				'unsubscribe'	=> $data['text_unsubscribes'],
				'profile'		=> $data['text_profile_updates'],
				'cleaned'		=> $data['text_cleaned_addresses'],
			),
		);
		
		$customer_groups = $data['customer_group_array'];
		$customer_groups[0] = $data['text_no_change'];
		$data['settings'][] = array(
			'key'		=> 'subscribed_group',
			'type'		=> 'select',
			'options'	=> $customer_groups,
		);
		$data['settings'][] = array(
			'key'		=> 'unsubscribed_group',
			'type'		=> 'select',
			'options'	=> $customer_groups,
		);
		
		$data['settings'][] = array(
			'key'		=> 'manual_sync',
			'type'		=> 'html',
			'content'	=> '
				<a class="btn btn-primary" onclick="sync()">' . $data['button_sync'] . '</a>
				<div id="syncing">' . $data['text_syncing'] . '</div>
				<style type="text/css">
					#syncing {
						display: none;
						background: #000;
						opacity: 0.5;
						color: #FFF;
						font-size: 100px;
						text-align: center;
						position: fixed;
						top: 0;
						left: 0;
						height: 100%;
						width: 100%;
						padding-top: 10%;
						z-index: 10000;
					}
				</style>
				<script type="text/javascript">
					function sync() {
						if (confirm("' . $data['text_sync_note'] . '")) {
							$("#syncing").fadeIn();
							$.get("index.php?route=' . $this->type . '/' . $this->name . '/sync&token=' . $data['token'] . '", function(data) {
								alert(data);
								$("#syncing").fadeOut();
							});
						}
					}
				</script>
			',
		);
		
		//------------------------------------------------------------------------------
		// Customer Creation Settings
		//------------------------------------------------------------------------------
		$data['settings'][] = array(
			'key'		=> 'customer_creation_settings',
			'type'		=> 'heading',
		);
		$data['settings'][] = array(
			'key'		=> 'autocreate',
			'type'		=> 'select',
			'options'	=> array('0' => $data['text_disabled'], '1' => $data['text_yes_disabled'], '2' => $data['text_yes_enabled']),
		);
		$data['settings'][] = array(
			'key'		=> 'email_password',
			'type'		=> 'select',
			'options'	=> array('0' => $data['text_no'], '1' => $data['text_yes']),
		);
		$data['settings'][] = array(
			'key'		=> 'emailtext_subject',
			'type'		=> 'multilingual_text',
			'default'	=> '[store]: Customer Account Created',
		);
		$data['settings'][] = array(
			'key'		=> 'emailtext_body',
			'type'		=> 'multilingual_textarea',
			'default'	=> "Your customer account has been successfully created. Your new password is:\n<br /><br />\n[password]\n<br /><br />\nThanks for choosing [store]!",
			'attributes'=> array('style' => 'height: 120px !important'),
		);
		
		//------------------------------------------------------------------------------
		// List Settings
		//------------------------------------------------------------------------------
		$data['settings'][] = array(
			'key'		=> 'list_settings',
			'type'		=> 'tab',
		);
		$data['settings'][] = array(
			'key'		=> 'list_settings',
			'type'		=> 'heading',
		);
		$data['settings'][] = array(
			'key'		=> 'listid',
			'type'		=> 'select',
			'options'	=> $data['mailchimp_lists'],
		);
		$data['settings'][] = array(
			'key'		=> 'list_mapping',
			'type'		=> 'heading',
		);
		
		if (file_exists(DIR_SYSTEM . 'library/mailchimp_integration_pro.php')) {
			include(DIR_SYSTEM . 'library/mailchimp_integration_pro.php');
		} else {
			$data['settings'][] = array(
				'type'		=> 'html',
				'content'	=> '<div class="text-info text-center" style="padding-bottom: 20px">' . $data['help_list_mapping'] . '</div>',
			);
			
			//------------------------------------------------------------------------------
			// Merge Tags
			//------------------------------------------------------------------------------
			$data['settings'][] = array(
				'key'		=> 'merge_tags',
				'type'		=> 'tab',
			);
			$data['settings'][] = array(
				'key'		=> 'merge_tags',
				'type'		=> 'heading',
			);
			$data['settings'][] = array(
				'type'		=> 'html',
				'content'	=> '<div class="text-info" style="padding-bottom: 20px">' . $data['help_merge_tags'] . '</div>',
			);
			if (empty($data['mailchimp_lists']['error'])) {
				foreach ($data['mailchimp_lists'] as $list_id => $list_name) {
					if (!$list_id) continue;
					$data['settings'][] = array(
						'key'		=> $list_id . '_FNAME',
						'type'		=> 'hidden',
						'default'	=> 'customer:firstname',
					);
					$data['settings'][] = array(
						'key'		=> $list_id . '_LNAME',
						'type'		=> 'hidden',
						'default'	=> 'customer:lastname',
					);
					$data['settings'][] = array(
						'key'		=> $list_id . '_ADDRESS',
						'type'		=> 'hidden',
						'default'	=> 'customer:address_id',
					);
					$data['settings'][] = array(
						'key'		=> $list_id . '_PHONE',
						'type'		=> 'hidden',
						'default'	=> 'customer:telephone',
					);
				}
			}
			
			//------------------------------------------------------------------------------
			// Interest Groups
			//------------------------------------------------------------------------------
			$data['settings'][] = array(
				'key'		=> 'interest_groups',
				'type'		=> 'tab',
			);
			$data['settings'][] = array(
				'key'		=> 'interest_groups',
				'type'		=> 'heading',
			);
			$data['settings'][] = array(
				'type'		=> 'html',
				'content'	=> '<div class="text-info text-center" style="padding-bottom: 20px">' . $data['help_interestgroups'] . '</div>',
			);
			
			//------------------------------------------------------------------------------
			// Module Settings
			//------------------------------------------------------------------------------
			$data['settings'][] = array(
				'key'		=> 'module_settings',
				'type'		=> 'tab',
			);
			$data['settings'][] = array(
				'key'		=> 'module_settings',
				'type'		=> 'heading',
			);
			$data['settings'][] = array(
				'type'		=> 'html',
				'content'	=> '<div class="text-info text-center" style="padding-bottom: 20px">' . $data['help_module_settings'] . '</div>',
			);
			foreach (array('firstname', 'lastname') as $field) {
				$data['settings'][] = array(
					'key'		=> 'modules_' . $field,
					'type'		=> 'select',
					'options'	=> array('hide' => $data['text_hide'], 'optional' => $data['text_optional'], 'required' => $data['text_required']),
				);
			}
		}
		
		$data['settings'][] = array(
			'key'		=> 'modules_redirect',
			'type'		=> 'text',
		);
		$data['settings'][] = array(
			'key'		=> 'modules_popup',
			'type'		=> 'select',
			'options'	=> array('0' => $data['text_no'], '1' => $data['text_yes']),
		);
		
		$data['settings'][] = array(
			'key'		=> 'module_text',
			'type'		=> 'heading',
		);
		$data['settings'][] = array(
			'key'		=> 'moduletext_heading',
			'type'		=> 'multilingual_text',
			'default'	=> 'Newsletter',
		);
		$data['settings'][] = array(
			'key'		=> 'moduletext_top',
			'type'		=> 'multilingual_text',
		);
		$data['settings'][] = array(
			'key'		=> 'moduletext_button',
			'type'		=> 'multilingual_text',
			'default'	=> 'Subscribe',
		);
		$data['settings'][] = array(
			'key'		=> 'moduletext_emptyfield',
			'type'		=> 'multilingual_text',
			'default'	=> 'Please fill in the required fields!',
		);
		$data['settings'][] = array(
			'key'		=> 'moduletext_invalidemail',
			'type'		=> 'multilingual_text',
			'default'	=> 'Please use a valid email address!',
		);
		$data['settings'][] = array(
			'key'		=> 'moduletext_success',
			'type'		=> 'multilingual_text',
			'default'	=> 'Success! Please click the confirmation link in the e-mail sent to you.',
		);
		$data['settings'][] = array(
			'key'		=> 'moduletext_error',
			'type'		=> 'multilingual_text',
		);
		$data['settings'][] = array(
			'key'		=> 'moduletext_subscribed',
			'type'		=> 'multilingual_text',
			'default'	=> 'You are subscribed as [email]. Edit your newsletter preferences <a href="index.php?route=account/newsletter">here</a>.',
		);
		
		$data['settings'][] = array(
			'key'		=> 'module_locations',
			'type'		=> 'heading',
		);
		if (version_compare(VERSION, '2.0') < 0) {
			$layouts = array();
			$this->load->model('design/layout');
			foreach ($this->model_design_layout->getLayouts() as $layout) {
				$layouts[$layout['layout_id']] = $layout['name'];
			}
			
			$positions = array(
				'content_top'		=> $data['text_content_top'],
				'column_left'		=> $data['text_column_left'],
				'column_right'		=> $data['text_column_right'],
				'content_bottom'	=> $data['text_content_bottom'],
			);
			
			$table = 'module';
			$sortby = 'layout';
			$data['settings'][] = array(
				'key'		=> $table,
				'type'		=> 'table_start',
				'columns'	=> array('action', 'status', 'layout', 'position', 'sort_order'),
			);
			foreach ($this->getTableRowNumbers($data, $table, $sortby) as $num => $rules) {
				$prefix = $table . '_' . $num . '_';
				$data['settings'][] = array(
					'type'		=> 'row_start',
				);
				$data['settings'][] = array(
					'key'		=> 'delete',
					'type'		=> 'button',
				);
				$data['settings'][] = array(
					'type'		=> 'column',
				);
				$data['settings'][] = array(
					'key'		=> $prefix . 'status',
					'type'		=> 'select',
					'options'	=> array('0' => $data['text_disabled'], '1' => $data['text_enabled']),
				);
				$data['settings'][] = array(
					'type'		=> 'column',
				);
				$data['settings'][] = array(
					'key'		=> $prefix . 'layout_id',
					'type'		=> 'select',
					'options'	=> $layouts,
				);
				$data['settings'][] = array(
					'type'		=> 'column',
				);
				$data['settings'][] = array(
					'key'		=> $prefix . 'position',
					'type'		=> 'select',
					'options'	=> $positions,
				);
				$data['settings'][] = array(
					'type'		=> 'column',
				);
				$data['settings'][] = array(
					'key'		=> $prefix . 'sort_order',
					'type'		=> 'text',
					'attributes'=> array('style' => 'width: 50px !important'),
				);
				$data['settings'][] = array(
					'type'		=> 'row_end',
				);
			}
			$data['settings'][] = array(
				'type'		=> 'table_end',
				'buttons'	=> 'add_row',
				'text'		=> 'button_add_module',
			);
		} else {
			$data['settings'][] = array(
				'type'		=> 'html',
				'content'	=> '<div class="text-info text-center">' . $data['help_module_locations'] . '  <a href="index.php?route=design/layout&token=' . $data['token'] . '">System > Design > Layouts</a></div>',
			);
		}
		
		//------------------------------------------------------------------------------
		// end settings
		//------------------------------------------------------------------------------
		
		$this->document->setTitle($data['heading_title']);
		
		if (version_compare(VERSION, '2.0') < 0) {
			$this->data = $data;
			$this->template = $this->type . '/' . $this->name . '.tpl';
			$this->children = array(
				'common/header',	
				'common/footer',
			);
			$this->response->setOutput($this->render());
		} else {
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			$this->response->setOutput($this->load->view($this->type . '/' . $this->name . '.tpl', $data));
		}
	}
	
	//==============================================================================
	// Setting functions
	//==============================================================================
	private function loadSettings(&$data = array()) {
		$data['saved'] = array();
		$settings_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `" . (version_compare(VERSION, '2.0.1') < 0 ? 'group' : 'code') . "` = '" . $this->db->escape($this->name) . "' ORDER BY `key` ASC");
		
		foreach ($settings_query->rows as $setting) {
			$key = str_replace($this->name . '_', '', $setting['key']);
			$value = (is_string($setting['value']) && strpos($setting['value'], 'a:') === 0) ? unserialize($setting['value']) : $setting['value'];
			
			if (is_array($value)) {
				foreach ($value as $num => $value_array) {
					foreach ($value_array as $k => $v) {
						$data['saved'][$key . '_' . $num . '_' . $k] = $v;
					}
				}
			} else {
				$data['saved'][$key] = $value;
			}
		}
		
		$data = array_merge($data, $this->load->language($this->type . '/' . $this->name));
	}
	
	private function getTableRowNumbers($data, $table, $sorting) {
		$groups = array();
		$rules = array();
		
		foreach ($data['saved'] as $key => $setting) {
			if (preg_match('/' . $table . '_(\d+)_' . $sorting . '/', $key, $matches)) {
				$groups[$setting][] = $matches[1];
			}
			if (preg_match('/' . $table . '_(\d+)_rule_(\d+)_type/', $key, $matches)) {
				$rules[$matches[1]][] = $matches[2];
			}
		}
		
		if (empty($groups)) {
			$groups = array('' => array('1'));
		}
		ksort($groups, SORT_STRING);
		
		$rows = array();
		foreach ($groups as $group) {
			foreach ($group as $num) {
				$rows[$num] = (empty($rules[$num])) ? array() : $rules[$num];
			}
		}
		
		return $rows;
	}
	
	public function saveSettings() {
		if (!$this->user->hasPermission('modify', $this->type . '/' . $this->name)) {
			echo 'PermissionError';
			return;
		}
		
		foreach ($this->request->post as $key => $value) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `" . (version_compare(VERSION, '2.0.1') < 0 ? 'group' : 'code') . "` = '" . $this->db->escape($this->name) . "'AND `key` = '" . $this->db->escape($this->name . '_' . $key) . "'");
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "setting SET
				`store_id` = 0,
				`" . (version_compare(VERSION, '2.0.1') < 0 ? 'group' : 'code') . "` = '" . $this->db->escape($this->name) . "',
				`key` = '" . $this->db->escape($this->name . '_' . $key) . "',
				`value` = '" . $this->db->escape(stripslashes(is_array($value) ? implode(';', $value) : $value)) . "',
				`serialized` = 0
			");
		}
		
		$this->convertModules();
	}
	
	public function deleteSetting() {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `" . (version_compare(VERSION, '2.0.1') < 0 ? 'group' : 'code') . "` = '" . $this->db->escape($this->name) . "' AND `key` = '" . $this->db->escape($this->name . '_' . $this->request->get['setting']) . "'");
	}
	
	private function convertModules() {
		$data = array();
		$this->loadSettings($data);
		$settings = $data['saved'];
		
		$modules = array();
		foreach ($settings as $key => $value) {
			if (strpos($key, 'module_') === 0) {
				$parts = explode('_', $key, 3);
				$modules[$parts[1]][$parts[2]] = $value;
			}
		}
		if (empty($modules)) return;
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `" . (version_compare(VERSION, '2.0.1') < 0 ? 'group' : 'code') . "` = '" . $this->db->escape($this->name) . "'AND `key` = '" . $this->db->escape($this->name . '_module') . "'");
		$this->db->query("
			INSERT INTO " . DB_PREFIX . "setting SET
			`store_id` = 0,
			`" . (version_compare(VERSION, '2.0.1') < 0 ? 'group' : 'code') . "` = '" . $this->db->escape($this->name) . "',
			`key` = '" . $this->db->escape($this->name . '_module') . "',
			`value` = '" . $this->db->escape(serialize($modules)) . "',
			`serialized` = 1
		");
		
		if (version_compare(VERSION, '2.0') < 0) return;
		
		if (version_compare(VERSION, '2.0.1') >= 0) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "module WHERE `code` = '" . $this->db->escape($this->name) . "'");
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "layout_module WHERE `code` LIKE '" . $this->db->escape($this->name) . ".%'");
		
		foreach ($modules as $module_id => $module) {
			if (version_compare(VERSION, '2.0.1') >= 0) {
				$this->db->query("
					INSERT INTO " . DB_PREFIX . "module SET
					`name` = '" . $this->db->escape($data) . "',
					`code` = '" . $this->db->escape($this->name) . "',
					`setting` = '" . $this->db->escape(serialize($module)) . "'
				");
				$module_id = $this->db->getLastId();
			}
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "layout_module SET
				`layout_id` = " . (int)$module['layout_id'] . ",
				`code` = '" . $this->db->escape($this->name . '.' . $module_id) . "',
				`position` = '" . $this->db->escape($module['position']) . "',
				`sort_order` = " . (int)$module['sort_order'] . "
			");
		}
	}
	
	//==============================================================================
	// Custom functions
	//==============================================================================
	public function sync() {
		if (!$this->user->hasPermission('modify', $this->type . '/' . $this->name)) {
			echo 'PermissionError';
			return;
		}
		
		$data = $this->load->language($this->type . '/' . $this->name);
		$this->loadsettings($data);
		if (empty($data['saved']['apikey']) || empty($data['saved']['listid'])) {
			echo $data['text_sync_error'];
			return;
		}
			
		$this->load->library($this->name);
		$mailchimp_integration = new MailChimp_Integration($this->config, $this->db, $this->log, $this->session);
		echo $mailchimp_integration->sync();
	}
}
?>