<?php
class ControllerCommonSearch extends Controller {
	public function index() {
		$this->load->language('common/search');
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		$data['text_search'] = $this->language->get('text_search');
		
		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/search.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/search.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/search.tpl', $data));
		}
	}
}