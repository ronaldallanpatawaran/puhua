<?php
class ControllerModuleSlideshow extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		// Owl Carousel
		// $this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
		// $this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');

		// Master Slider
		$this->document->addStyle('catalog/view/javascript/jquery/masterslider/style/masterslider.css');
		$this->document->addStyle('catalog/view/javascript/jquery/masterslider/skins/default/style.css');
		$this->document->addScript('catalog/view/javascript/jquery/masterslider/masterslider.min.js');
		$this->document->addScript('catalog/view/javascript/jquery/masterslider/jquery.easing.min.js');

		$data['blank_gif'] = 'catalog/view/javascript/jquery/masterslider/blank.gif';

		$data['banners'] = array();

		$data['width'] = $setting['width'];
		$data['height'] = $setting['height'];
		$data['layout'] = $setting['layout'];
		$data['view'] = $setting['view'];

		$results = $this->model_design_banner->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				if ($result['description']) {
					$description = html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8');
				} else {
					$description = false;
				}

				$data['banners'][] = array(
					'title'       => $result['title'],
					'description' => $description,
					'link'        => $result['link'],
					'original'    => 'image/' . $result['image'],
					'image'       => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}

		$data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/slideshow.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/slideshow.tpl', $data);
		} else {
			return $this->load->view('default/template/module/slideshow.tpl', $data);
		}
	}
}