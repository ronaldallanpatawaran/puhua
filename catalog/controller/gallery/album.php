<?php 
class ControllerGalleryAlbum extends Controller {
  public function index() {
    $this->load->language('gallery/album');

	$this->load->model('catalog/gallimage');

	$this->load->model('tool/image');

	$data['breadcrumbs'] = array();

	$data['breadcrumbs'][] = array(
		'text' => $this->language->get('text_home'),
		'href' => $this->url->link('common/home')
	);

	$data['breadcrumbs'][] = array(
		'text' => $this->language->get('heading_title'),
		'href' => $this->url->link('gallery/album')
	);

	$data['text_gallery'] = $this->language->get('text_gallery');
	$data['text_category'] = $this->language->get('text_category');
	$data['text_album'] = $this->language->get('text_album');
	$data['text_empty'] = $this->language->get('text_empty');

	$data['button_continue'] = $this->language->get('button_continue');
	
	$data['continue'] = $this->url->link('common/home');

	if (isset($this->request->get['gcat'])) {
		$gcat = '';

		$parts = explode('_', (string)$this->request->get['gcat']);

		$category_id = (int)array_pop($parts);

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
	} else {
		$category_id = 0;
	}

	$category_info = $this->model_catalog_gallimage->getGallCategory($category_id);

	if($category_id != 0) {
		$this->document->setTitle($category_info['meta_title']);
		$this->document->setDescription($category_info['meta_description']);
		$this->document->setKeywords($category_info['meta_keyword']);
		$this->document->addLink($this->url->link('gallery/album', 'gcat=' . $this->request->get['gcat']), 'canonical');
		$data['heading_title'] = $category_info['name'];
	} else {
		$this->document->setTitle($this->language->get('heading_title'));
		$data['heading_title'] = $this->language->get('heading_title');
	}

	// Set the last category breadcrumb
	if($category_id != 0) {
		$data['breadcrumbs'][] = array(
			'text' => $category_info['name'],
			'href' => $this->url->link('gallery/album', 'gcat=' . $this->request->get['gcat'])
		);

		if ($category_info['image']) {
			$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
		} else {
			$data['thumb'] = '';
		}

		$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
	} else {
		$data['thumb'] = '';
		$data['description'] = '';
	}

	$data['categories'] = array();

	$results = $this->model_catalog_gallimage->getGallCategories($category_id);

	foreach ($results as $result) {
		$cwidth  = 500;
		$cheight = 500;
		if ($result['image']) {
			$image = $this->model_tool_image->resize($result['image'], $cwidth, $cheight);
		} else {
			$image = $this->model_tool_image->resize('placeholder.png', $cwidth, $cheight);
		}
		if($category_id != 0) {
			$data['categories'][] = array(
				'name'  => $result['name'],
				'thumb' => $image,
				'href'  => $this->url->link('gallery/album', 'gcat=' . $this->request->get['gcat'] . '_' . $result['category_id'])
			);
		} else {
			$data['categories'][] = array(
				'name'  => $result['name'],
				'thumb' => $image,
				'href'  => $this->url->link('gallery/album', 'gcat=' . $result['category_id'])
			);
		}
	}

	$data['gallalbums'] = array();
		
	$gallalbums = $this->model_catalog_gallimage->getGallalbumsByCategory($category_id);

	foreach ($gallalbums as $gallalbum) {
		$gallalbum_info = $this->model_catalog_gallimage->getGallalbum($gallalbum);
		
		if ($gallalbum) {
			$gallimages = array();
	
			$results = $this->model_catalog_gallimage->getGallimage($gallalbum['gallimage_id']);	
			
			if ($results) {
				foreach ($results as $result) {
					$gwidth 	= ($gallalbum['gwidth'] == 0) ? 232 : $gallalbum['gwidth'];
					$gheight 	= ($gallalbum['gheight'] == 0) ? 162 : $gallalbum['gheight'];
					$pwidth 	= ($gallalbum['pwidth'] == 0) ? 489 : $gallalbum['pwidth'];
					$pheight 	= ($gallalbum['pheight'] == 0) ? 342 : $gallalbum['pheight'];

					if ($result['image']) {
						$child_thumb = $this->model_tool_image->resize($result['image'], $gwidth, $gheight);
						$child_popup = $this->model_tool_image->resize($result['image'], $pwidth, $pheight);
					} else {
						$child_thumb = $this->model_tool_image->resize('placeholder.png', $gwidth, $gheight);
						$child_popup = $this->model_tool_image->resize('placeholder.png', $pwidth, $pheight);
					}
					$gallimages[] = array(
						'title' => $result['title'],
						'link'  => $result['link'],
						'thumb' => $child_thumb,
						'popup' => $child_popup
					);
				}
			}

			if ($gallalbum['image']) {
				$thumb = $this->model_tool_image->resize($gallalbum['image'], 232, 162);
				$popup = $this->model_tool_image->resize($gallalbum['image'], 489, 342);
			} else {
				$thumb = $this->model_tool_image->resize('placeholder.png', 232, 162);
				$popup = $this->model_tool_image->resize('placeholder.png', 489, 342);
			}

			$data['gallalbums'][] = array(
				'gallimage_id' => $gallalbum['gallimage_id'],
				'name'         => $gallalbum['name'],
				'thumb'   	   => $thumb,
				'popup'		   => $popup,
				'images'       => $gallimages,
				'href'         => $this->url->link('gallery/gallery', 'gcat=' . $this->request->get['gcat'] . '&gallimage_id=' . $gallalbum['gallimage_id'])
			);
		}
	}
	
	$data['column_left'] = $this->load->controller('common/column_left');
	$data['column_right'] = $this->load->controller('common/column_right');
	$data['content_top'] = $this->load->controller('common/content_top');
	$data['content_bottom'] = $this->load->controller('common/content_bottom');
	$data['footer'] = $this->load->controller('common/footer');
	$data['header'] = $this->load->controller('common/header');

    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/gallery/album.tpl')) {
		$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/gallery/album.tpl', $data));
    } else {
		$this->response->setOutput($this->load->view('default/template/gallery/album.tpl', $data));
    }
  }
}
?>