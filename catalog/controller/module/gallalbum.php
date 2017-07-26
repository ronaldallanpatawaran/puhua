<?php
class ControllerModuleGallalbum extends Controller {
	public function index($setting) {
		static $module = 0;
		$this->load->language('module/gallalbum');

		$data['heading_title'] = $this->language->get('heading_title');

		$this->load->model('catalog/gallimage');
		$this->load->model('tool/image');
		
		$data['headtitle'] 	= $setting['headtitle_' . $this->config->get('config_language_id')];
		$data['descstat'] 	= $setting['descstat'];
		$data['chardesc']	= $setting['chardesc'];
		// $data['popupstyle']	= $setting['popupstyle'];
		$data['showimg'] 	= $setting['showimg'];
		$data['imgheight']  = $setting['height'];
		
		$this->document->addStyle('catalog/view/javascript/jquery/gallery-colorbox/gallery.css');

		$data['gallalbums'] = array();
		
		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}
		
		$gallalbums = array_slice($this->model_catalog_gallimage->getGallalbums(), 0, (int)$setting['limit']);

		foreach ($gallalbums as $gallalbum) {
			$gallalbum_info = $this->model_catalog_gallimage->getGallalbum($gallalbum);
			
			if ($gallalbum) {
				if ($gallalbum['image']) {
					$image = $this->model_tool_image->resize($gallalbum['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}

			$data['gallalbums'][] = array(
				'gallimage_id' => $gallalbum['gallimage_id'],
				'name'        => $gallalbum['name'],
				'description' => utf8_substr(strip_tags(html_entity_decode($gallalbum['description'], ENT_QUOTES, 'UTF-8')), 0, $data['chardesc']) . '..',
				'thumb'   	 => $image,
				'href'        => $this->url->link('gallery/gallery', 'gallimage_id=' . $gallalbum['gallimage_id'])
			);
		}
		}
		
		$data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/gallalbum.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/gallalbum.tpl', $data);
		} else {
			return $this->load->view('default/template/module/gallalbum.tpl', $data);
		}
	}
}