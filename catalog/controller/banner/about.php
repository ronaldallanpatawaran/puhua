<?php 
	
class ControllerBannerAbout extends Controller { 

	public function index(){
		$this->load->language('banner/banners');
		
		$data['text_title'] = $this->language->get('text_aboutus');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/banner/about.tpl')) {
		return $this->load->view($this->config->get('config_template') . '/template/banner/about.tpl', $data);
		} else {
			return $this->load->view('default/template/banner/about.tpl', $data);
		}
	}



}




























