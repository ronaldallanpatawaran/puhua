<?php
class ControllerModuleCarousel extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');

		$data['banners'] = array();

		/* For about us carousel selection */

		if(isset($_GET['information_id']) && $_GET['information_id']){
			$information_id = $_GET['information_id'];
			$type = isset($_GET['type']) ? $_GET['type'] : 0;

			if ($information_id == 10 && $type == 0) {
				$setting['banner_id'] = 10;
			}else if ($information_id == 10 && $type == 1) {
				$setting['banner_id'] = 11;
			}else if ($information_id == 10 && $type == 2) {
				$setting['banner_id'] = 12;
			}else if($information_id == 8){
				$setting['banner_id'] = 13;
			}
		}

		$results = $this->model_design_banner->getBanner($setting['banner_id']);

		$data['slides'] = isset($setting['slides_per_page']) && $setting['slides_per_page'] !="" ? (int)$setting['slides_per_page']: 4;

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}

		$data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/carousel.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/carousel.tpl', $data);
		} else {
			return $this->load->view('default/template/module/carousel.tpl', $data);
		}
	}
}