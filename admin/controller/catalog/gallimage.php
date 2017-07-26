<?php
class ControllerCatalogGallimage extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/gallimage');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/gallimage');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/gallimage');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/gallimage');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_gallimage->addGallimage($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/gallimage', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/gallimage');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/gallimage');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_gallimage->editGallimage($this->request->get['gallimage_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/gallimage', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/gallimage');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/gallimage');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $gallimage_id) {
				$this->model_catalog_gallimage->deleteGallimage($gallimage_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/gallimage', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/gallimage', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		$data['insert'] = $this->url->link('catalog/gallimage/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('catalog/gallimage/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['gallimages'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$gallimage_total = $this->model_catalog_gallimage->getTotalGallimages();

		$results = $this->model_catalog_gallimage->getGallimages($filter_data);

		foreach ($results as $result) {
			$data['gallimages'][] = array(
				'gallimage_id' => $result['gallimage_id'],
				'name'      => $result['name'],
				'status'    => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'edit'      => $this->url->link('catalog/gallimage/edit', 'token=' . $this->session->data['token'] . '&gallimage_id=' . $result['gallimage_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_insert'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/gallimage', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('catalog/gallimage', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $gallimage_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/gallimage', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($gallimage_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($gallimage_total - $this->config->get('config_limit_admin'))) ? $gallimage_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $gallimage_total, ceil($gallimage_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/gallimage_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['gallimage_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_link'] = $this->language->get('entry_link');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_gsize'] = $this->language->get('entry_gsize');
		$data['entry_psize'] = $this->language->get('entry_psize');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_layout'] = $this->language->get('entry_layout');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_gallimage_add'] = $this->language->get('button_gallimage_add');
		$data['button_remove'] = $this->language->get('button_remove');
		
		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_gallery'] = $this->language->get('tab_gallery');
		$data['tab_design'] = $this->language->get('tab_design');
		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_category'] = $this->language->get('help_category');

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
		
		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}

		if (isset($this->error['gallimage_image'])) {
			$data['error_gallimage_image'] = $this->error['gallimage_image'];
		} else {
			$data['error_gallimage_image'] = array();
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/gallimage', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		if (!isset($this->request->get['gallimage_id'])) {
			$data['action'] = $this->url->link('catalog/gallimage/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('catalog/gallimage/edit', 'token=' . $this->session->data['token'] . '&gallimage_id=' . $this->request->get['gallimage_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('catalog/gallimage', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['gallimage_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$gallimage_info = $this->model_catalog_gallimage->getGallimage($this->request->get['gallimage_id']);
		}

		$data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['gallimage_description'])) {
			$data['gallimage_description'] = $this->request->post['gallimage_description'];
		} elseif (isset($this->request->get['gallimage_id'])) {
			$data['gallimage_description'] = $this->model_catalog_gallimage->getGallimageDescriptions($this->request->get['gallimage_id']);
		} else {
			$data['gallimage_description'] = array();
		}

		// Categories
		$this->load->model('catalog/gallimage_category');

		if (isset($this->request->post['gallimage_category'])) {
			$categories = $this->request->post['gallimage_category'];
		} elseif (isset($this->request->get['gallimage_id'])) {
			$categories = $this->model_catalog_gallimage->getGallimageCategories($this->request->get['gallimage_id']);
		} else {
			$categories = array();
		}

		$data['gallimage_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_gallimage_category->getCategory($category_id);

			if ($category_info) {
				$data['gallimage_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name' => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}
		
		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['gallimage_store'])) {
			$data['gallimage_store'] = $this->request->post['gallimage_store'];
		} elseif (isset($this->request->get['gallimage_id'])) {
			$data['gallimage_store'] = $this->model_catalog_gallimage->getGallimageStores($this->request->get['gallimage_id']);
		} else {
			$data['gallimage_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($gallimage_info)) {
			$data['keyword'] = $gallimage_info['keyword'];
		} else {
			$data['keyword'] = '';
		}
		
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($gallimage_info)) {
			$data['image'] = $gallimage_info['image'];
		} else {
			$data['image'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($gallimage_info) && is_file(DIR_IMAGE . $gallimage_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($gallimage_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($gallimage_info)) {
			$data['sort_order'] = $gallimage_info['sort_order'];
		} else {
			$data['sort_order'] = 0;
		}
		
		if (isset($this->request->post['gwidth'])) {
			$data['gwidth'] = $this->request->post['gwidth'];
		} elseif (!empty($gallimage_info)) {
			$data['gwidth'] = $gallimage_info['gwidth'];
		} else {
			$data['gwidth'] = '';
		}
		
		if (isset($this->request->post['gheight'])) {
			$data['gheight'] = $this->request->post['gheight'];
		} elseif (!empty($gallimage_info)) {
			$data['gheight'] = $gallimage_info['gheight'];
		} else {
			$data['gheight'] = '';
		}
		
		if (isset($this->request->post['pwidth'])) {
			$data['pwidth'] = $this->request->post['pwidth'];
		} elseif (!empty($gallimage_info)) {
			$data['pwidth'] = $gallimage_info['pwidth'];
		} else {
			$data['pwidth'] = '';
		}
		
		if (isset($this->request->post['pheight'])) {
			$data['pheight'] = $this->request->post['pheight'];
		} elseif (!empty($gallimage_info)) {
			$data['pheight'] = $gallimage_info['pheight'];
		} else {
			$data['pheight'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($gallimage_info)) {
			$data['status'] = $gallimage_info['status'];
		} else {
			$data['status'] = true;
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('tool/image');

		if (isset($this->request->post['gallimage_image'])) {
			$gallimage_images = $this->request->post['gallimage_image'];
		} elseif (isset($this->request->get['gallimage_id'])) {
			$gallimage_images = $this->model_catalog_gallimage->getGallimageImages($this->request->get['gallimage_id']);
		} else {
			$gallimage_images = array();
		}

		$data['gallimage_images'] = array();

		foreach ($gallimage_images as $gallimage_image) {
			if (is_file(DIR_IMAGE . $gallimage_image['image'])) {
				$image = $gallimage_image['image'];
				$thumb = $gallimage_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['gallimage_images'][] = array(
				'gallimage_image_description' => $gallimage_image['gallimage_image_description'],
				'link'                        => $gallimage_image['link'],
				'image'                       => $image,
				'thumb'                       => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order'                  => $gallimage_image['sort_order']
			);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['gallery_layout'])) {
			$data['gallery_layout'] = $this->request->post['gallery_layout'];
		} elseif (isset($this->request->get['gallimage_id'])) {
			$data['gallery_layout'] = $this->model_catalog_gallimage->getGalleryLayouts($this->request->get['gallimage_id']);
		} else {
			$data['gallery_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/gallimage_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/gallimage')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['gallimage_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}

		//if (isset($this->request->post['gallimage_image'])) {
			// foreach ($this->request->post['gallimage_image'] as $gallimage_image_id => $gallimage_image) {
				// foreach ($gallimage_image['gallimage_image_description'] as $language_id => $gallimage_image_description) {
					// if ((utf8_strlen($gallimage_image_description['title']) < 2) || (utf8_strlen($gallimage_image_description['title']) > 64)) {
						// $this->error['gallimage_image'][$gallimage_image_id][$language_id] = $this->language->get('error_title');
					// }
				// }
			// }
		// }

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/gallimage')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}