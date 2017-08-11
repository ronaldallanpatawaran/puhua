<?php 
class ControllerInformationProduct extends Controller{
	
	public function index(){
		$this->load->model('catalog/category');
		$this->load->language('information/information');


		$data = array();
		// Get categories related by the product page category as parent category
		$data['categories'] = $this->model_catalog_category->getCategories(64);

		$data['category_id'] = isset($_GET['category_id']) && $_GET['category_id'] ? $_GET['category_id'] : $data['categories'][0]['category_id']; 

		$data['active_category'] = $this->model_catalog_category->getCategory($data['category_id']);

		$data['content_top'] = $this->load->controller('common/content_top');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$category_id = $data['category_id'];

		$data['products'] = array();

		$filter_data = array('filter_category_id' => $category_id );

		$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

		$results = $this->model_catalog_product->getProducts($filter_data);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
			}

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}

			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}

			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
			} else {
				$tax = false;
			}

			if ($this->config->get('config_review_status')) {
				$rating = (int)$result['rating'];
			} else {
				$rating = false;
			}

			if($category_id != 0) {
				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					'href'        => $this->url->link('product/product', 'path=' . $category_id . '&product_id=' . $result['product_id'])
				);
			} else {
				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}
		}


		// Languages

		$data['text_benefits_1'] = $this->language->get('text_benefits_1');
		$data['text_benefits_2'] = $this->language->get('text_benefits_2');
		$data['text_benefits_3'] = $this->language->get('text_benefits_3');
		$data['text_benefits_4'] = $this->language->get('text_benefits_4');
		$data['text_benefits_5'] = $this->language->get('text_benefits_5');
		$data['text_benefits_6'] = $this->language->get('text_benefits_6');
		$data['text_benefits_7'] = $this->language->get('text_benefits_7');
		$data['text_benefits_8'] = $this->language->get('text_benefits_8');

		//print_r($data['products']); die();

		$data['shop'] = $this->url->link('product/category');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/product.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/product.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/information/product.tpl', $data));
		}
	}
}

































 ?>