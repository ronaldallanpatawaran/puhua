<?php
class ControllerCommonHeader extends Controller {
	public function index() {
		$data['title'] = $this->document->getTitle();

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
			$frontend = HTTP_CATALOG;
		} else {
			$data['base'] = HTTP_SERVER;
			$frontend = HTTPS_CATALOG;
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_admin_icon'))) {
			$data['icon'] = $frontend . 'image/' . $this->config->get('config_admin_icon');
		} else {
			$data['icon'] = '';
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_admin_logo'))) {
			$data['logo'] = $frontend . 'image/' . $this->config->get('config_admin_logo');
		} else {
			$data['logo'] = '';
		}

		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$this->load->language('common/header');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_order'] = $this->language->get('text_order');
		$data['text_order_status'] = $this->language->get('text_order_status');
		$data['text_complete_status'] = $this->language->get('text_complete_status');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_customer'] = $this->language->get('text_customer');
		$data['text_online'] = $this->language->get('text_online');
		$data['text_approval'] = $this->language->get('text_approval');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_stock'] = $this->language->get('text_stock');
		$data['text_review'] = $this->language->get('text_review');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_store'] = $this->language->get('text_store');
		$data['text_front'] = $this->language->get('text_front');
		$data['text_help'] = $this->language->get('text_help');
		$data['text_homepage'] = $this->language->get('text_homepage');
		$data['text_documentation'] = $this->language->get('text_documentation');
		$data['text_support'] = $this->language->get('text_support');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->user->getUserName());
		$data['text_logout'] = $this->language->get('text_logout');

		if (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
			$data['logged'] = '';

			$data['home'] = $this->url->link('common/dashboard', '', 'SSL');
		} else {
			$data['logged'] = true;

			$data['home'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');
			$data['logout'] = $this->url->link('common/logout', 'token=' . $this->session->data['token'], 'SSL');

			// Orders
			$this->load->model('sale/order');

			// Processing Orders
			$data['order_status_total'] = $this->model_sale_order->getTotalOrders(array('filter_order_status' => implode(',', $this->config->get('config_processing_status'))));
			$data['order_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&filter_order_status=' . implode(',', $this->config->get('config_processing_status')), 'SSL');

			// Complete Orders
			$data['complete_status_total'] = $this->model_sale_order->getTotalOrders(array('filter_order_status' => implode(',', $this->config->get('config_complete_status'))));
			$data['complete_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&filter_order_status=' . implode(',', $this->config->get('config_complete_status')), 'SSL');

			// Returns
			$this->load->model('sale/return');

			$return_total = $this->model_sale_return->getTotalReturns(array('filter_return_status_id' => $this->config->get('config_return_status_id')));

			$data['return_total'] = $return_total;

			$data['return'] = $this->url->link('sale/return', 'token=' . $this->session->data['token'], 'SSL');

			// Customers
			$this->load->model('report/customer');

			$data['online_total'] = $this->model_report_customer->getTotalCustomersOnline();

			$data['online'] = $this->url->link('report/customer_online', 'token=' . $this->session->data['token'], 'SSL');

			$this->load->model('sale/customer');

			$customer_total = $this->model_sale_customer->getTotalCustomers(array('filter_approved' => false));

			$data['customer_total'] = $customer_total;
			$data['customer_approval'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&filter_approved=0', 'SSL');

			// Products
			$this->load->model('catalog/product');

			$product_total = $this->model_catalog_product->getTotalProducts(array('filter_quantity' => 0));

			$data['product_total'] = $product_total;

			$data['product'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&filter_quantity=0', 'SSL');

			// Reviews
			$this->load->model('catalog/review');

			$review_total = $this->model_catalog_review->getTotalReviews(array('filter_status' => false));

			$data['review_total'] = $review_total;

			$data['review'] = $this->url->link('catalog/review', 'token=' . $this->session->data['token'] . '&filter_status=0', 'SSL');

			// Affliate
			$this->load->model('marketing/affiliate');

			$affiliate_total = $this->model_marketing_affiliate->getTotalAffiliates(array('filter_approved' => false));

			$data['affiliate_total'] = $affiliate_total;
			$data['affiliate_approval'] = $this->url->link('marketing/affiliate', 'token=' . $this->session->data['token'] . '&filter_approved=1', 'SSL');

			$data['alerts'] = $customer_total + $product_total + $review_total + $return_total + $affiliate_total;

			// Online Stores
			$data['stores'] = array();

			$data['stores'][] = array(
				'name' => $this->config->get('config_name'),
				'href' => $frontend
			);

			$this->load->model('setting/store');

			$results = $this->model_setting_store->getStores();


			////
			$this->load->model('user/user');
			$data['heading_title_2']	= $this->language->get('heading_title_2');
			$data['heading_title_av']	= $this->language->get('heading_title_av');
			$data['heading_title_user']	= $this->language->get('heading_title_user');
			$data['text_group_id']		= $this->language->get('text_group_id');
			$data['text_group_name']= $this->language->get('text_group_name');
			$data['text_user_id']		= $this->language->get('text_user_id');
			$data['text_username_ad']= $this->language->get('text_username_ad');
			$data['text_view']		= $this->language->get('text_view');
			$data['heading_title_superuser'] = $this->language->get('heading_title_superuser');
			$all_group = $this->model_user_user->getAllGroupId();
			$all_user = $this->model_user_user->getAllUserId();
			$data['all_group'] = array();
			foreach ($all_group as $group) {$data['all_group'][] = array ('groupid' => $group['user_group_id'],'groupname' => $group['name']);}
			$data['all_user'] = array();
			foreach ($all_user as $user) {$data['all_user'][] = array ('userid' => $user['user_id'],'usergroupid'	=> $user['user_group_id'],'username' => $user['username']);}
			$this->load->model('user/user');
			$this->language->load('user/user');
			$data['heading_title'] = $this->language->get('heading_title');
			$data['text_enabled'] = $this->language->get('text_enabled');
			$data['text_disabled'] = $this->language->get('text_disabled');	
			$data['entry_username'] = $this->language->get('entry_username');
			$data['entry_password'] = $this->language->get('entry_password');
			$data['entry_confirm'] = $this->language->get('entry_confirm');
			$data['entry_firstname'] = $this->language->get('entry_firstname');
			$data['entry_lastname'] = $this->language->get('entry_lastname');
			$data['entry_email'] = $this->language->get('entry_email');
			$data['entry_user_group'] = $this->language->get('entry_user_group');
			$data['entry_status'] = $this->language->get('entry_status');
			$data['entry_captcha'] = $this->language->get('entry_captcha');
			$data['button_save'] = $this->language->get('button_save');
			$data['button_cancel'] = $this->language->get('button_cancel');  
			if (isset($this->error['warning'])){$data['error_warning'] = $this->error['warning'];}else{$data['error_warning'] = '';}
			if (isset($this->error['username'])){$data['error_username'] = $this->error['username'];}else{$data['error_username'] = '';}
			if (isset($this->error['password'])) {$data['error_password'] = $this->error['password'];} else {$data['error_password'] = '';}
			if (isset($this->error['confirm'])) {$data['error_confirm'] = $this->error['confirm'];} else {$data['error_confirm'] = '';}
			if (isset($this->error['firstname'])) {$data['error_firstname'] = $this->error['firstname'];} else {$data['error_firstname'] = '';}
			if (isset($this->error['lastname'])) {$data['error_lastname'] = $this->error['lastname'];} else {$data['error_lastname'] = '';}
			$url = '';	
			if (!isset($this->request->get['user_id'])) {$data['action_SA'] = $this->url->link('user/user/insertSuper', 'token=' . $this->session->data['token'] . $url, 'SSL');} else {$data['action_SA'] = $this->url->link('user/user/update', 'token=' . $this->session->data['token'] . '&user_id=' . $this->request->get['user_id'] . $url, 'SSL');}  
			if (isset($this->request->get['user_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {$user_info = $this->model_user_user->getUser($this->request->get['user_id']);}
			if (isset($this->request->post['username'])) {$data['username'] = $this->request->post['username'];
			} elseif (!empty($user_info)) {$data['username'] = $user_info['username'];
			} else {$data['username'] = '';}
			if (isset($this->request->post['password'])) {$data['password'] = $this->request->post['password'];
			} else {$data['password'] = '';}
			if (isset($this->request->post['confirm'])) {$data['confirm'] = $this->request->post['confirm'];
			} else {$data['confirm'] = '';}
			if (isset($this->request->post['firstname'])) {$data['firstname'] = $this->request->post['firstname'];
			} elseif (!empty($user_info)) {$data['firstname'] = $user_info['firstname'];
			} else { $data['firstname'] = '';}
			if (isset($this->request->post['lastname'])) { $data['lastname'] = $this->request->post['lastname'];
			} elseif (!empty($user_info)) { $data['lastname'] = $user_info['lastname'];
			} else { $data['lastname'] = '';}
			if (isset($this->request->post['email'])){$data['email'] = $this->request->post['email'];
			} elseif (!empty($user_info)) {$data['email'] = $user_info['email'];
			} else {$data['email'] = '';}	
			////
		
			foreach ($results as $result) {
				$data['stores'][] = array(
					'name' => $result['name'],
					'href' => $result['url']
				);
			}
		}

 
	        $data['lang'] = $this->config->get('pim_language');
	       // var_dump($data);
	      
		return $this->load->view('common/header.tpl', $data);
	}
}