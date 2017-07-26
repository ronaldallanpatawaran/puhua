<?php
class ModelCatalogGallimage extends Model {
	public function getGallName($gallimage_id){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "gallimage_description where gallimage_id= " . $gallimage_id . " limit 1");
		return $query->row['name'];
	}
	
	public function getGallimage($gallimage_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallimage_image gi LEFT JOIN " . DB_PREFIX . "gallimage_image_description gid ON (gi.gallimage_image_id  = gid.gallimage_image_id) WHERE gi.gallimage_id = '" . (int)$gallimage_id . "' AND gid.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY gi.sort_order ASC");

		return $query->rows;
	}
	
	public function getGallalbum($gallimage_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "gallimage g LEFT JOIN " . DB_PREFIX . "gallimage_description gd ON (g.gallimage_id = gd.gallimage_id) LEFT JOIN " . DB_PREFIX . "gallimage_to_store g2s ON (g.gallimage_id = g2s.gallimage_id) WHERE g.gallimage_id = '" . (int)$gallimage_id . "' AND gd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND g2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND g.status = '1'");

		return $query->row;
	}
	
	public function getGallalbums() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallimage g LEFT JOIN " . DB_PREFIX . "gallimage_description gd ON (g.gallimage_id = gd.gallimage_id) LEFT JOIN " . DB_PREFIX . "gallimage_to_store g2s ON (g.gallimage_id = g2s.gallimage_id) WHERE gd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND g2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND g.status = '1' ORDER BY g.sort_order, LCASE(gd.name) ASC");

		return $query->rows;
	}
	
	public function getGallalbumsByCategory($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallimage g LEFT JOIN " . DB_PREFIX . "gallimage_description gd ON (g.gallimage_id = gd.gallimage_id) LEFT JOIN " . DB_PREFIX . "gallimage_to_store g2s ON (g.gallimage_id = g2s.gallimage_id) LEFT JOIN " . DB_PREFIX . "gallimage_to_category g2c ON (g.gallimage_id = g2c.gallimage_id) WHERE g2c.category_id = '" . (int)$category_id . "' AND gd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND g2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND g.status = '1' ORDER BY g.sort_order, LCASE(gd.name) ASC");

		return $query->rows;
	}

	public function getGallCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "gallimage_category gc LEFT JOIN " . DB_PREFIX . "gallimage_category_description gcd ON (gc.category_id = gcd.category_id) LEFT JOIN " . DB_PREFIX . "gallimage_category_to_store gc2s ON (gc.category_id = gc2s.category_id) WHERE gc.category_id = '" . (int)$category_id . "' AND gcd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND gc2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND gc.status = '1'");

		return $query->row;
	}

	public function getGallCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallimage_category gc LEFT JOIN " . DB_PREFIX . "gallimage_category_description gcd ON (gc.category_id = gcd.category_id) LEFT JOIN " . DB_PREFIX . "gallimage_category_to_store gc2s ON (gc.category_id = gc2s.category_id) WHERE gc.parent_id = '" . (int)$parent_id . "' AND gcd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND gc2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND gc.status = '1' ORDER BY gc.sort_order, LCASE(gcd.name)");

		return $query->rows;
	}

	public function getGalleryLayoutId($gallimage_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallimage_to_layout WHERE gallimage_id = '" . (int)$gallimage_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getGalleryCategoryLayoutId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallimage_category_to_layout WHERE category_id = '" . (int)$category_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}
}