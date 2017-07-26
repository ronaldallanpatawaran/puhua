<?php
class ControllerModuleMAnufacturer extends Controller {
	public function index($setting) {
		$this->load->language('module/manufacturer');

		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['manufacturer_id'])) {
			$data['manufacturer_id'] = (int)$this->request->get['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}

		$this->load->model('tool/image');

		$this->load->model('catalog/manufacturer');

		$data['manufacturers'] = array();

		$manufacturers = $this->model_catalog_manufacturer->getManufacturers();

		foreach ($manufacturers as $manufacturer) {
			if ($manufacturer['image']) {
				$image = $this->model_tool_image->resize($manufacturer['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
			} else {
				$image = false;
			}
			
			$data['manufacturers'][] = array(
				'manufacturer_id' => $manufacturer['manufacturer_id'],
				'name'            => $manufacturer['name'] ,
				'href'            => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturer['manufacturer_id']),
				'image'		      => $image
			);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/manufacturer.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/manufacturer.tpl', $data);
		} else {
			return $this->load->view('default/template/module/manufacturer.tpl', $data);
		}
	}
}