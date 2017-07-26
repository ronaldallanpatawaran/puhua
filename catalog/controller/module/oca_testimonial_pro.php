<?php
class ControllerModuleOCATestimonialPro extends Controller {
	public function index($setting) {

		static $module = 0;

		$this->document->addStyle('catalog/view/javascript/ocatestimonialpro/ocatestimonialpro.php');
		$this->document->addStyle('catalog/view/javascript/ocatestimonialpro/owl.carousel.css');
		$this->document->addScript('catalog/view/javascript/ocatestimonialpro/owl.carousel.min.js');

		$this->document->addScript('http://ajax.googleapis.com/ajax/libs/webfont/1.5.6/webfont.js');

		$this->load->language('module/oca_testimonial_pro');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['button_next'] = $this->language->get('button_next');
		$data['button_prev'] = $this->language->get('button_prev');

		$data['button_viewall'] = $this->language->get('button_viewall');
		$data['viewall'] = $this->url->link('information/testimonial');

		$this->load->model('catalog/oca_testimonial');

		$this->load->model('tool/image');

		$data['testimonials'] = array();

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}

		$testimonials = array_slice($setting['testimonial'], 0, (int)$setting['limit']);

		foreach ($testimonials as $testimonial_id) {
			$testimonial_info = $this->model_catalog_oca_testimonial->getTestimonial($testimonial_id);

			if ($testimonial_info) {
				if ($testimonial_info['image']) {
					$image = $this->model_tool_image->resize($testimonial_info['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}

				$data['testimonials'][] = array(
					'testimonial_id'  => $testimonial_info['testimonial_id'],
					'thumb'       => $image,
					'author'        => $testimonial_info['author'],
					'text' =>  html_entity_decode($testimonial_info['text'], ENT_QUOTES, 'UTF-8'),
				);
			}
		}

		$data['module'] = $module++;
		$data['font'] = $setting['font'];
		if($setting['autoplay']) {
			$data['autoplay_delay'] = $setting['autoplay_delay'];
		} else {
			$data['autoplay_delay'] = 'false';
		}
		$data['autoplay_on_hover'] = $setting['autoplay_on_hover'];
		$data['navigation'] = $setting['navigation'];
		$data['limit_row'] = $setting['limit_row'];

		if ($data['testimonials']) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/oca_testimonial_pro.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/oca_testimonial_pro.tpl', $data);
			} else {
				return $this->load->view('default/template/module/oca_testimonial_pro.tpl', $data);
			}
		}
	}
}