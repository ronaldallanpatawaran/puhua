<?php 
	class ControllerBannerContact extends Controller { 

		public function index(){
			$this->load->language('banner/banners');
			
			$data['text_title'] = $this->language->get('text_contacts');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/banner/contact.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/banner/contact.tpl', $data);
			} else {
				return $this->load->view('default/template/banner/contact.tpl', $data);
			}
		}




	}




























