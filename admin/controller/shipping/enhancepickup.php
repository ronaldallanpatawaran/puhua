<?php
class ControllerShippingEnhancePickup extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('shipping/enhancepickup');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$this->model_setting_setting->editSetting('enhancepickup', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');
		
		$data['entry_tax'] = $this->language->get('entry_tax');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_desc'] = $this->language->get('entry_desc');
		
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_cost'] = $this->language->get('entry_cost');
		
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['button_add_store'] = $this->language->get('button_add_store');
		

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/enhancepickup', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('shipping/enhancepickup', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['enhancepickup_geo_zone_id'])) {
			$data['enhancepickup_geo_zone_id'] = $this->request->post['enhancepickup_geo_zone_id'];
		} else {
			$data['enhancepickup_geo_zone_id'] = $this->config->get('enhancepickup_geo_zone_id');
		}
		
		if (isset($this->request->post['enhancepickup_status'])) {
			$data['enhancepickup_status'] = $this->request->post['enhancepickup_status'];
		} else {
			$data['enhancepickup_status'] = $this->config->get('enhancepickup_status');
		}
		
		if (isset($this->request->post['enhancepickup_sort_order'])) {
			$data['enhancepickup_sort_order'] = $this->request->post['enhancepickup_sort_order'];
		} else {
			$data['enhancepickup_sort_order'] = $this->config->get('enhancepickup_sort_order');
		}
		
		$data['module_row'] = 0;
		if (isset($this->request->post['enhancepickup_title'])) {
			$data['enhancepickup_title'] = $this->request->post['enhancepickup_title'];
			$data['module_row'] = count($this->request->post['enhancepickup_title']);
		} else {
			$data['enhancepickup_title'] = $this->config->get('enhancepickup_title');
			$data['module_row'] = count($this->config->get('enhancepickup_title'));
		}
		if (isset($this->request->post['enhancepickup_desc'])) {
			$data['enhancepickup_desc'] = $this->request->post['enhancepickup_desc'];
		} else {
			$data['enhancepickup_desc'] = $this->config->get('enhancepickup_desc');
		}
		
		if (isset($this->request->post['enhancepickup_total'])) {
			$data['enhancepickup_total'] = $this->request->post['enhancepickup_total'];
		} else {
			$data['enhancepickup_total'] = $this->config->get('enhancepickup_total');
		}
		if (isset($this->request->post['enhancepickup_cost'])) {
			$data['enhancepickup_cost'] = $this->request->post['enhancepickup_cost'];
		} else {
			$data['enhancepickup_cost'] = $this->config->get('enhancepickup_cost');
		}
		
		$this->load->model('localisation/location');

		$data['locations'] = $this->model_localisation_location->getLocations();
		
		$this->load->model('localisation/geo_zone');
		
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
						
				
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('shipping/enhancepickup.tpl', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/enhancepickup')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>