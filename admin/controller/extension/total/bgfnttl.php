<?php
class ControllerExtensiontotalbgfnttl extends Controller {
	private $error = array();
	private $modpath = '';
	private $modtpl = 'total/bgfnttl.tpl'; 
	private $modname = 'bgfnttl';
	private $modssl = '';
	private $modtext = 'BUY N GET N FREE OR $ % OFF PRO';
	private $modid = '23069';
	private $modemail = 'opencarttools@gmail.com';

	public function __construct($registry) {
		parent::__construct($registry);
		
		$this->modpath = (substr(VERSION,0,3)=='2.3') ? 'extension/total/bgfnttl' : 'total/bgfnttl';
 		if(substr(VERSION,0,3)=='2.3') {
			$this->modtpl = 'extension/total/bgfnttl';
		} else if(substr(VERSION,0,3)=='2.2') {
			$this->modtpl = 'total/bgfnttl';
		}
 		$this->modssl = (substr(VERSION,0,3)=='2.3' || substr(VERSION,0,3)=='2.2') ? true : 'SSL';
 	}
	
	public function index() {
		$data = $this->load->language($this->modpath);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting($this->modname, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if(substr(VERSION,0,3)=='2.3') {
				$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=total', $this->modssl));
			} else {
				$this->response->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], $this->modssl));
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');
 		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
 		$data['entry_status'] = $this->language->get('entry_status');
  		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], $this->modssl)
		);
		
		if(substr(VERSION,0,3)=='2.3') {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_extension'),
				'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=total', $this->modssl)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_total'),
				'href' => $this->url->link('extension/total', 'token=' . $this->session->data['token'], $this->modssl)
			);
		}

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link($this->modpath, 'token=' . $this->session->data['token'], $this->modssl)
		);

		$data['action'] = $this->url->link($this->modpath, 'token=' . $this->session->data['token'], $this->modssl);
		
		if(substr(VERSION,0,3)=='2.3') {
			$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=total', $this->modssl);
		} else {
			$data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], $this->modssl);
		}

		$data[$this->modname.'_status'] = $this->setvalue($this->modname.'_status');
		$data[$this->modname.'_sort_order'] = $this->setvalue($this->modname.'_sort_order');
		$data['modname'] = $this->modname;
		$data['modemail'] = $this->modemail;
  		  
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($this->modtpl, $data));
	}
	
	protected function setvalue($postfield) {
		if (isset($this->request->post[$postfield])) {
			$postfield_value = $this->request->post[$postfield];
		} else {
			$postfield_value = $this->config->get($postfield);
		} 	
 		return $postfield_value;
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', $this->modpath)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	} 
}