<?php
class ControllerGalleryGallery extends Controller {
	public function index() {
		$this->load->language('gallery/gallery');

		$this->load->model('catalog/gallimage');
		
		$this->load->model('tool/image');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['gallimage_id'])) {
			$gallimage_id = (int)$this->request->get['gallimage_id'];
		} else {
			$gallimage_id = 0;
		}
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_gallery'),
			'href' => $this->url->link('gallery/album')
		);

		if (isset($this->request->get['gcat'])) {
			$gcat = '';

			$parts = explode('_', (string)$this->request->get['gcat']);

			foreach ($parts as $gcat_id) {
				if (!$gcat) {
					$gcat = (int)$gcat_id;
				} else {
					$gcat .= '_' . (int)$gcat_id;
				}

				$category_info = $this->model_catalog_gallimage->getGallCategory($gcat_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('gallery/album', 'gcat=' . $gcat)
					);
				}
			}
		} 

		$gallimage_info = $this->model_catalog_gallimage->getGallalbum($gallimage_id);

		if ($gallimage_info) {
			$this->document->setTitle($gallimage_info['meta_title']);
			$this->document->setDescription($gallimage_info['meta_description']);
			$this->document->setKeywords($gallimage_info['meta_keyword']);
			$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');

			$data['breadcrumbs'][] = array(
				'text' => $gallimage_info['name'],
				'href' => $this->url->link('gallery/gallery', 'gallimage_id=' .  $gallimage_id)
			);

			$data['heading_title'] = $gallimage_info['name'];

			$data['button_continue'] = $this->language->get('button_continue');
			
			if ($gallimage_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($gallimage_info['image'], 200, 200);
				$data['popup'] = $this->model_tool_image->resize($gallimage_info['image'], 500, 500);
			} else {
				$data['thumb'] = '';
				$data['popup'] = '';
			}
			
			$data['gallimage_id'] = $gallimage_info['gallimage_id'];
			$data['gwidth'] 	= ($gallimage_info['gwidth'] == 0) ? 500 : $gallimage_info['gwidth'];
			$data['gheight'] 	= ($gallimage_info['gheight'] == 0) ? 500 : $gallimage_info['gheight'];
			$data['pwidth'] 	= ($gallimage_info['pwidth'] == 0) ? 500 : $gallimage_info['pwidth'];
			$data['pheight'] 	= ($gallimage_info['pheight'] == 0) ? 500 : $gallimage_info['pheight'];

			$data['description'] = html_entity_decode($gallimage_info['description'], ENT_QUOTES, 'UTF-8');
			
			$data['gallimages'] = array();

			$results = $this->model_catalog_gallimage->getGallimage($gallimage_info['gallimage_id']);	
			
			if ($results) {
				foreach ($results as $result) {
					if (file_exists(DIR_IMAGE . $result['image'])) {
						$data['gallimages'][] = array(
							'title' => $result['title'],
							'link'  => $result['link'],
							'thumb' => $this->model_tool_image->resize($result['image'], $data['gwidth'], $data['gheight']),
							'popup' => $this->model_tool_image->resize($result['image'], $data['pwidth'], $data['pheight'])
						);
					}
				}
			}

			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/gallery/gallery.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/gallery/gallery.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/gallery/gallery.tpl', $data));
			}
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('gallery/gallery', 'gallimage_id=' . $gallimage_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}

	public function agree() {
		$this->load->model('catalog/gallimage');

		if (isset($this->request->get['gallimage_id'])) {
			$gallimage_id = (int)$this->request->get['gallimage_id'];
		} else {
			$gallimage_id = 0;
		}

		$output = '';

		$gallimage_info = $this->model_catalog_gallimage->getGallimage($gallimage_id);

		if ($gallimage_info) {
			$output .= html_entity_decode($gallimage_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
		}

		$this->response->setOutput($output);
	}
}