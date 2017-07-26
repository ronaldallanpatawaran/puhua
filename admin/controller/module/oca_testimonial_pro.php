<?php
class ControllerModuleOCATestimonialPro extends Controller {
	private $error = array();

	public function index() {

		$this->load->model('catalog/oca_testimonial_pro');
		$this->model_catalog_oca_testimonial_pro->CreateDB();

		$this->load->language('module/oca_testimonial_pro');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('oca_testimonial_pro', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$output  = '<?php' . "\n";
			$output .= '$font = ' . "'" .  $this->request->post['font'] . "'" . ";\n";
			$output .= '$font_size = ' . "'" .  $this->request->post['font_size'] . "'" . ";\n";
			$output .= '?>';

			$file = fopen(DIR_CATALOG . 'view/javascript/ocatestimonialpro/ocatestimonialpro_var.php', 'w');

			fwrite($file, $output);

			fclose($file);	
						
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_testimonial'] = $this->language->get('entry_testimonial');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_limit_row'] = $this->language->get('entry_limit_row');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['entry_font'] = $this->language->get('entry_font');
		$data['entry_font_size'] = $this->language->get('entry_font_size');
		$data['entry_navigation'] = $this->language->get('entry_navigation');
		$data['entry_autoplay'] = $this->language->get('entry_autoplay');
		$data['entry_autoplay_delay'] = $this->language->get('entry_autoplay_delay');
		$data['entry_autoplay_on_hover'] = $this->language->get('entry_autoplay_on_hover');

		$data['help_font'] = $this->language->get('help_font');
		$data['help_this_change'] = $this->language->get('help_this_change');
		$data['help_navigation'] = $this->language->get('help_navigation');
		$data['help_autoplay'] = $this->language->get('help_autoplay');
		$data['help_autoplay_delay'] = $this->language->get('help_autoplay_delay');
		$data['help_autoplay_on_hover'] = $this->language->get('help_autoplay_on_hover');


		$data['help_testimonial'] = $this->language->get('help_testimonial');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		
		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}
		
		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
		}

		if (isset($this->error['autoplay_delay'])) {
			$data['error_autoplay_delay'] = $this->error['autoplay_delay'];
		} else {
			$data['error_autoplay_delay'] = '';
		}


		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/oca_testimonial_pro', 'token=' . $this->session->data['token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/oca_testimonial_pro', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);			
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/oca_testimonial_pro', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('module/oca_testimonial_pro', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
		
		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		
		$data['testimonials'] = array();
		
		if (isset($this->request->post['testimonial'])) {
			$testimonials = $this->request->post['testimonial'];
		} elseif (!empty($module_info)) {
			$testimonials = $module_info['testimonial'];
		} else {
			$testimonials = array();
		}	
		
		foreach ($testimonials as $testimonial_id) {
			$testimonial_info = $this->model_catalog_oca_testimonial_pro->getTestimonial($testimonial_id);

			if ($testimonial_info) {
				$data['testimonials'][] = array(
					'testimonial_id' => $testimonial_info['testimonial_id'],
					'name'       => $testimonial_info['text']
				);
			}
		}
		
		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info)) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = 5;
		}

		if (isset($this->request->post['limit_row'])) {
			$data['limit_row'] = $this->request->post['limit_row'];
		} elseif (!empty($module_info)) {
			$data['limit_row'] = $module_info['limit_row'];
		} else {
			$data['limit_row'] = 5;
		}	
				
		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($module_info)) {
			$data['width'] = $module_info['width'];
		} else {
			$data['width'] = 200;
		}	
			
		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($module_info)) {
			$data['height'] = $module_info['height'];
		} else {
			$data['height'] = 200;
		}	

		if (isset($this->request->post['font'])) {
			$data['font'] = $this->request->post['font'];
		} elseif (!empty($module_info)) {
			$data['font'] = $module_info['font'];
		} else {
			$data['font'] = 'Oswald';
		}

		if (isset($this->request->post['font_size'])) {
			$data['font_size'] = $this->request->post['font_size'];
		} elseif (!empty($module_info)) {
			$data['font_size'] = $module_info['font_size'];
		} else {
			$data['font_size'] = 'Oswald';
		}

		if (isset($this->request->post['autoplay'])) {
			$data['autoplay'] = $this->request->post['autoplay'];
		} elseif (!empty($module_info)) {
			$data['autoplay'] = $module_info['autoplay'];
		} else {
			$data['autoplay'] = '1';
		}

		if (isset($this->request->post['autoplay_delay'])) {
			$data['autoplay_delay'] = $this->request->post['autoplay_delay'];
		} elseif (!empty($module_info)) {
			$data['autoplay_delay'] = $module_info['autoplay_delay'];
		} else {
			$data['autoplay_delay'] = '3000';
		}

		if (isset($this->request->post['autoplay_on_hover'])) {
			$data['autoplay_on_hover'] = $this->request->post['autoplay_on_hover'];
		} elseif (!empty($module_info)) {
			$data['autoplay_on_hover'] = $module_info['autoplay_on_hover'];
		} else {
			$data['autoplay_on_hover'] = 'true';
		}

		if (isset($this->request->post['navigation'])) {
			$data['navigation'] = $this->request->post['navigation'];
		} elseif (!empty($module_info)) {
			$data['navigation'] = $module_info['navigation'];
		} else {
			$data['navigation'] = '1';
		}	
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
				
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/oca_testimonial_pro.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/oca_testimonial_pro')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		if (!$this->request->post['width']) {
			$this->error['width'] = $this->language->get('error_width');
		}
		
		if (!$this->request->post['height']) {
			$this->error['height'] = $this->language->get('error_height');
		}

		if (!$this->request->post['autoplay_delay']) {
			$this->error['autoplay_delay'] = $this->language->get('error_autoplay_delay');
		}
		
		return !$this->error;
	}
}