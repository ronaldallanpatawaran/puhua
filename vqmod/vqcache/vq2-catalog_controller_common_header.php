<?php
class ControllerCommonHeader extends Controller {
	public function index() {
		$data['title'] = $this->document->getTitle();
		$this->document->addScript('catalog/view/javascript/Lettering.js-master/jquery.lettering.js');

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (isset($this->request->get['route'])) {
			$data['route'] = $this->request->get['route'];
		} else {
			$data['route'] = 'common/home';
		}

		if (isset($this->request->get['information_id'])) {
			$data['information_id'] = $this->request->get['information_id'];
		} else {
			$data['information_id'] = 0;
		}

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
$data['extra_tags'] = $this->document->getExtraTags();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		if ($this->config->get('config_google_analytics_status')) {
			$data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		} else {
			$data['google_analytics'] = '';
		}

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$data['icon'] = $server . 'image/' . $this->config->get('config_icon');
		} else {
			$data['icon'] = '';
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');


		$data['text_home'] 		= $this->language->get('text_home');
		$data['text_aboutus'] 	= $this->language->get('text_aboutus');
		$data['text_services'] 	= $this->language->get('text_services');
		$data['text_products'] 	= $this->language->get('text_products');
		$data['text_gallery']  	= $this->language->get('text_gallery');
		$data['text_news']	   	= $this->language->get('text_news');
		$data['text_shop']	   	= $this->language->get('text_shop');
		$data['text_contact'] 	= $this->language->get('text_contact');
		$data['text_product']	= $this->language->get('text_product');
		
		$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));

		$data['text_account'] 		= $this->language->get('text_account');
		$data['text_register'] 		= $this->language->get('text_register');
		$data['text_login'] 		= $this->language->get('text_login');
		$data['text_order'] 		= $this->language->get('text_order');
		$data['text_transaction'] 	= $this->language->get('text_transaction');
		$data['text_download'] 		= $this->language->get('text_download');
		$data['text_logout'] 		= $this->language->get('text_logout');
		$data['text_checkout'] 		= $this->language->get('text_checkout');
		$data['text_category'] 		= $this->language->get('text_category');
		$data['text_menu'] 			= $this->language->get('text_menu');
		$data['text_all'] 			= $this->language->get('text_all');

		$data['home'] 			= $this->url->link('common/home');
		$data['aboutus'] 		= $this->url->link('information/information&information_id=8');
		$data['services'] 		= $this->url->link('information/information&information_id=12');
		$data['products'] 		= $this->url->link('product/category');
		$data['news']			= $this->url->link('news/headlines');
		$data['products']		= $this->url->link('information/product');
		$data['shop']			= $this->url->link('product/category');
		$data['wishlist'] 		= $this->url->link('account/wishlist', '', 'SSL');
		$data['logged'] 		= $this->customer->isLogged();
		$data['account'] 		= $this->url->link('account/account', '', 'SSL');
		$data['register'] 		= $this->url->link('account/register', '', 'SSL');
		$data['login'] 			= $this->url->link('account/login', '', 'SSL');
		$data['order'] 			= $this->url->link('account/order', '', 'SSL');
		$data['transaction'] 	= $this->url->link('account/transaction', '', 'SSL');
		$data['download'] 		= $this->url->link('account/download', '', 'SSL');
		$data['logout'] 		= $this->url->link('account/logout', '', 'SSL');
		$data['shopping_cart'] 	= $this->url->link('checkout/cart');
		$data['checkout'] 		= $this->url->link('checkout/checkout', '', 'SSL');
		$data['contact'] 		= $this->url->link('information/contact');
		$data['telephone'] 		= $this->config->get('config_telephone');
		$data['search']			= $this->url->link('common/search');
		$data['gallery']		= $this->url->link('gallery/album&gcat=1');

		$status = true;

		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$robots = explode("\n", str_replace(array("\r\n", "\r"), "\n", trim($this->config->get('config_robots'))));

			foreach ($robots as $robot) {
				if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
					$status = false;

					break;
				}
			}
		}

		// Menu Active
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['top_category_id'] = $parts[0];
		} else {
			$data['top_category_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['top_child_id'] = $parts[1];
		} else {
			$data['top_child_id'] = 0;
		}

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$children_data[] = array(
						'category_id'	=> $child['category_id'],
						'name'  		=> $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href'  		=> $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}

				// Level 1
				$data['categories'][] = array(
					'category_id'	=> $category['category_id'],
					'name'     		=> $category['name'],
					'children' 		=> $children_data,
					'column'   		=> $category['column'] ? $category['column'] : 1,
					'href'     		=> $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['cart'] = $this->load->controller('common/cart');
		$data['content_header'] = $this->load->controller('common/content_header');

		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = ' pid-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = ' path-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = ' mid-' . $this->request->get['manufacturer_id'];
			} elseif (isset($this->request->get['information_id'])) {
				$class = ' iid-' . $this->request->get['information_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/header.tpl', $data);
		} else {
			return $this->load->view('default/template/common/header.tpl', $data);
		}
	}
}