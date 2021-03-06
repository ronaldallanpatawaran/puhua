<?php
class ControllerCommonFooter extends Controller {
	public function index() {
if (version_compare(VERSION, '2.0') < 0) {
					$this->data['mailchimp_integration'] = ($this->config->get('mailchimp_integration_modules_popup')) ? $this->getChild('module/mailchimp_integration') : '';
				} else {
					$data['mailchimp_integration'] = ($this->config->get('mailchimp_integration_modules_popup')) ? $this->load->controller('module/mailchimp_integration') : '';
				}
		$this->load->language('common/footer');

		$data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_myaccount'] = $this->language->get('text_myaccount');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		$data['text_product']	= $this->language->get('text_product');
		$data['text_follow_us']	= $this->language->get('text_follow_us');
		$data['text_all_products'] = $this->language->get('text_all_products');
		$data['text_news']	= $this->language->get('text_news');
		$data['text_firstcom'] = $this->language->get('text_firstcom');

		$data['text_fb'] = $this->language->get('text_fb');
		$data['text_tw'] = $this->language->get('text_tw');
		$data['text_ig'] = $this->language->get('text_ig');

		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', 'SSL');
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', 'SSL');
		$data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');

		$this->language->load('module/news');
		$data['blog_url'] = $this->url->link('news/ncategory');
		$data['blog_name'] = $this->language->get('text_blogpage');
		
		$data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

		$data['url_fb'] = $this->config->get('config_fb_url');
		$data['url_tw'] = $this->config->get('config_tw_url');
		$data['url_ig'] = $this->config->get('config_ig_url');

		$data['powered'] = sprintf($this->language->get('text_powered'), date('Y', time()), $this->config->get('config_name'));

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->whosonline($ip, $this->customer->getId(), $url, $referer);
		}
		
		$data['content_footer'] = $this->load->controller('common/content_footer');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/footer.tpl', $data);
		} else {
			return $this->load->view('default/template/common/footer.tpl', $data);
		}
	}
}