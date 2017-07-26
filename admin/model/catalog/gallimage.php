<?php
class ModelCatalogGallimage extends Model {
	public function addGallimage($data) {
		$this->event->trigger('pre.admin.add.gallimage', $data);
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "gallimage SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', gwidth = '" . (int)$data['gwidth'] . "', gheight = '" . (int)$data['gheight'] . "', pwidth = '" . (int)$data['pwidth'] . "', pheight = '" . (int)$data['pheight'] . "'");

		$gallimage_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "gallimage SET image = '" . $this->db->escape($data['image']) . "' WHERE gallimage_id = '" . (int)$gallimage_id . "'");
		}
		
		foreach ($data['gallimage_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "gallimage_description SET gallimage_id = '" . (int)$gallimage_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['gallimage_category'])) {
			foreach ($data['gallimage_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallimage_to_category SET gallimage_id = '" . (int)$gallimage_id . "', category_id = '" . (int)$category_id . "'");
			}
		}
		
		if (isset($data['gallimage_store'])) {
			foreach ($data['gallimage_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallimage_to_store SET gallimage_id = '" . (int)$gallimage_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// Set which layout to use with this category
		if (isset($data['gallery_layout'])) {
			foreach ($data['gallery_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallimage_to_layout SET gallimage_id = '" . (int)$gallimage_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}
		
		if (!empty($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'gallimage_id=" . (int)$gallimage_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if ($this->config->get('config_auto_generate_seo_url')) {
			$query = $this->db->query("SELECT gd.gallimage_id, gd.name, gd.language_id, l.code FROM " . DB_PREFIX . "gallimage g inner join " . DB_PREFIX . "gallimage_description gd on g.gallimage_id = gd.gallimage_id inner join " . DB_PREFIX . "language l on l.language_id = gd.language_id WHERE g.gallimage_id = '" . (int)$gallimage_id . "'");
						
			foreach ($query->rows as $gallery_row) {
				if(strlen($gallery_row['name']) > 1) {
					$slug = generateSlug($gallery_row['name']);

					$exist_query = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.query = 'gallimage_id=" . $gallery_row['gallimage_id'] . "'");
					
					if (!$exist_query->num_rows) {
						$exist_keyword = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "'");

						if ($exist_keyword->num_rows) { 
							$exist_keyword_lang = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "' AND " . DB_PREFIX . "url_alias.query <> 'gallimage_id=" . $gallery_row['gallimage_id'] . "'");

							if ($exist_keyword_lang->num_rows) {
								$slug = generateSlug($gallery_row['name']).'-'.rand();
							} else {
								$slug = generateSlug($gallery_row['name']).'-'.$gallery_row['code'];
							}
						}	
						
						$add_query = "INSERT INTO " . DB_PREFIX . "url_alias (query, keyword) VALUES ('gallimage_id=" . $gallery_row['gallimage_id'] . "', '" . $slug . "')";

						$this->db->query($add_query);
					}
				}
			}
		}

		if (isset($data['gallimage_image'])) {
			foreach ($data['gallimage_image'] as $gallimage_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallimage_image SET gallimage_id = '" . (int)$gallimage_id . "', link = '" .  $this->db->escape($gallimage_image['link']) . "', image = '" .  $this->db->escape($gallimage_image['image']) . "', sort_order = '" . (int)$gallimage_image['sort_order'] . "'");

				$gallimage_image_id = $this->db->getLastId();

				foreach ($gallimage_image['gallimage_image_description'] as $language_id => $gallimage_image_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "gallimage_image_description SET gallimage_image_id = '" . (int)$gallimage_image_id . "', language_id = '" . (int)$language_id . "', gallimage_id = '" . (int)$gallimage_id . "', title = '" .  $this->db->escape($gallimage_image_description['title']) . "'");
				}
			}
		}
		
		$this->cache->delete('gallimage');

		$this->event->trigger('post.admin.add.gallimage', $gallimage_id);

		return $gallimage_id;
	}

	public function editGallimage($gallimage_id, $data) {
		$this->event->trigger('pre.admin.edit.gallimage', $data);
		
		$this->db->query("UPDATE " . DB_PREFIX . "gallimage SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', gwidth = '" . (int)$data['gwidth'] . "', gheight = '" . (int)$data['gheight'] . "', pwidth = '" . (int)$data['pwidth'] . "', pheight = '" . (int)$data['pheight'] . "' WHERE gallimage_id = '" . (int)$gallimage_id . "'");
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "gallimage SET image = '" . $this->db->escape($data['image']) . "' WHERE gallimage_id = '" . (int)$gallimage_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallimage_description WHERE gallimage_id = '" . (int)$gallimage_id . "'");

		foreach ($data['gallimage_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "gallimage_description SET gallimage_id = '" . (int)$gallimage_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "gallimage_to_category WHERE gallimage_id = '" . (int)$gallimage_id . "'");

		if (isset($data['gallimage_category'])) {
			foreach ($data['gallimage_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallimage_to_category SET gallimage_id = '" . (int)$gallimage_id . "', category_id = '" . (int)$category_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallimage_to_store WHERE gallimage_id = '" . (int)$gallimage_id . "'");

		if (isset($data['gallimage_store'])) {
			foreach ($data['gallimage_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallimage_to_store SET gallimage_id = '" . (int)$gallimage_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "gallimage_to_layout WHERE gallimage_id = '" . (int)$gallimage_id . "'");

		if (isset($data['gallery_layout'])) {
			foreach ($data['gallery_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallimage_to_layout SET gallimage_id = '" . (int)$gallimage_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'gallimage_id=" . (int)$gallimage_id . "'");

		if (!empty($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'gallimage_id=" . (int)$gallimage_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if ($this->config->get('config_auto_generate_seo_url')) {
			$query = $this->db->query("SELECT gd.gallimage_id, gd.name, gd.language_id, l.code FROM " . DB_PREFIX . "gallimage g inner join " . DB_PREFIX . "gallimage_description gd on g.gallimage_id = gd.gallimage_id inner join " . DB_PREFIX . "language l on l.language_id = gd.language_id WHERE g.gallimage_id = '" . (int)$gallimage_id . "'");
						
			foreach ($query->rows as $gallery_row) {
				if(strlen($gallery_row['name']) > 1) {
					$slug = generateSlug($gallery_row['name']);

					$exist_query = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.query = 'gallimage_id=" . $gallery_row['gallimage_id'] . "'");
					
					if (!$exist_query->num_rows) {
						$exist_keyword = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "'");

						if ($exist_keyword->num_rows) { 
							$exist_keyword_lang = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "' AND " . DB_PREFIX . "url_alias.query <> 'gallimage_id=" . $gallery_row['gallimage_id'] . "'");

							if ($exist_keyword_lang->num_rows) {
								$slug = generateSlug($gallery_row['name']).'-'.rand();
							} else {
								$slug = generateSlug($gallery_row['name']).'-'.$gallery_row['code'];
							}
						}	
						
						$add_query = "INSERT INTO " . DB_PREFIX . "url_alias (query, keyword) VALUES ('gallimage_id=" . $gallery_row['gallimage_id'] . "', '" . $slug . "')";

						$this->db->query($add_query);
					}
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "gallimage_image WHERE gallimage_id = '" . (int)$gallimage_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallimage_image_description WHERE gallimage_id = '" . (int)$gallimage_id . "'");

		if (isset($data['gallimage_image'])) {
			foreach ($data['gallimage_image'] as $gallimage_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallimage_image SET gallimage_id = '" . (int)$gallimage_id . "', link = '" .  $this->db->escape($gallimage_image['link']) . "', image = '" .  $this->db->escape($gallimage_image['image']) . "', sort_order = '" . (int)$gallimage_image['sort_order'] . "'");

				$gallimage_image_id = $this->db->getLastId();

				foreach ($gallimage_image['gallimage_image_description'] as $language_id => $gallimage_image_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "gallimage_image_description SET gallimage_image_id = '" . (int)$gallimage_image_id . "', language_id = '" . (int)$language_id . "', gallimage_id = '" . (int)$gallimage_id . "', title = '" .  $this->db->escape($gallimage_image_description['title']) . "'");
				}
			}
		}
		
		$this->cache->delete('gallimage');

		$this->event->trigger('post.admin.edit.gallimage', $gallimage_id);
	}

	public function deleteGallimage($gallimage_id) {
		$this->event->trigger('pre.admin.delete.gallimage', $gallimage_id);
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallimage WHERE gallimage_id = '" . (int)$gallimage_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallimage_description WHERE gallimage_id = '" . (int)$gallimage_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallimage_to_category WHERE gallimage_id = '" . (int)$gallimage_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallimage_to_store WHERE gallimage_id = '" . (int)$gallimage_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallimage_to_layout WHERE gallimage_id = '" . (int)$gallimage_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'gallimage_id=" . (int)$gallimage_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallimage_image WHERE gallimage_id = '" . (int)$gallimage_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallimage_image_description WHERE gallimage_id = '" . (int)$gallimage_id . "'");

		if ($this->config->get('config_auto_generate_seo_url')) {
			$query = $this->db->query("SELECT gd.gallimage_id, gd.name, gd.language_id, l.code FROM " . DB_PREFIX . "gallimage g inner join " . DB_PREFIX . "gallimage_description gd on g.gallimage_id = gd.gallimage_id inner join " . DB_PREFIX . "language l on l.language_id = gd.language_id WHERE g.gallimage_id = '" . (int)$gallimage_id . "'");
						
			foreach ($query->rows as $gallery_row) {
				if(strlen($gallery_row['name']) > 1) {
					$slug = generateSlug($gallery_row['name']);

					$exist_query = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.query = 'gallimage_id=" . $gallery_row['gallimage_id'] . "'");
					
					if (!$exist_query->num_rows) {
						$exist_keyword = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "'");

						if ($exist_keyword->num_rows) { 
							$exist_keyword_lang = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "' AND " . DB_PREFIX . "url_alias.query <> 'gallimage_id=" . $gallery_row['gallimage_id'] . "'");

							if ($exist_keyword_lang->num_rows) {
								$slug = generateSlug($gallery_row['name']).'-'.rand();
							} else {
								$slug = generateSlug($gallery_row['name']).'-'.$gallery_row['code'];
							}
						}	
						
						$add_query = "INSERT INTO " . DB_PREFIX . "url_alias (query, keyword) VALUES ('gallimage_id=" . $gallery_row['gallimage_id'] . "', '" . $slug . "')";

						$this->db->query($add_query);
					}
				}
			}
		}

		$this->event->trigger('post.admin.delete.gallimage', $gallimage_id);
	}

	public function getGallimage($gallimage_id) {
		
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'gallimage_id=" . (int)$gallimage_id . "') AS keyword FROM " . DB_PREFIX . "gallimage WHERE gallimage_id = '" . (int)$gallimage_id . "'");

		return $query->row;
	}

	public function getGallimages($data = array()) {
		
		$sql = "SELECT * FROM " . DB_PREFIX . "gallimage g LEFT JOIN " . DB_PREFIX . "gallimage_description gd ON (g.gallimage_id = gd.gallimage_id) WHERE gd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$sort_data = array(
			'gd.name',
			'g.sort_order',
			'g.status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getGallimagesByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallimage g LEFT JOIN " . DB_PREFIX . "gallimage_description gd ON (g.gallimage_id = gd.gallimage_id) LEFT JOIN " . DB_PREFIX . "gallimage_to_category g2c ON (g.gallimage_id = g2c.gallimage_id) WHERE gd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND g2c.category_id = '" . (int)$category_id . "' ORDER BY gd.name ASC");

		return $query->rows;
	}
	
	public function getGallimageDescriptions($gallimage_id) {
		$gallimage_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallimage_description WHERE gallimage_id = '" . (int)$gallimage_id . "'");

		foreach ($query->rows as $result) {
			$gallimage_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
			);
		}

		return $gallimage_description_data;
	}

	public function getGallimageCategories($gallimage_id) {
		$gallimage_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallimage_to_category WHERE gallimage_id = '" . (int)$gallimage_id . "'");

		foreach ($query->rows as $result) {
			$gallimage_category_data[] = $result['category_id'];
		}

		return $gallimage_category_data;
	}
	
	public function getGallimageStores($gallimage_id) {
		$gallimage_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallimage_to_store WHERE gallimage_id = '" . (int)$gallimage_id . "'");

		foreach ($query->rows as $result) {
			$gallimage_store_data[] = $result['store_id'];
		}

		return $gallimage_store_data;
	}

	public function getGallimageImages($gallimage_id) {
		$gallimage_image_data = array();

		$gallimage_image_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallimage_image WHERE gallimage_id = '" . (int)$gallimage_id . "' ORDER BY sort_order ASC");

		foreach ($gallimage_image_query->rows as $gallimage_image) {
			$gallimage_image_description_data = array();

			$gallimage_image_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallimage_image_description WHERE gallimage_image_id = '" . (int)$gallimage_image['gallimage_image_id'] . "' AND gallimage_id = '" . (int)$gallimage_id . "'");

			foreach ($gallimage_image_description_query->rows as $gallimage_image_description) {
				$gallimage_image_description_data[$gallimage_image_description['language_id']] = array('title' => $gallimage_image_description['title']);
			}

			$gallimage_image_data[] = array(
				'gallimage_image_description' => $gallimage_image_description_data,
				'link'                        => $gallimage_image['link'],
				'image'                       => $gallimage_image['image'],
				'sort_order'                  => $gallimage_image['sort_order']
			);
		}

		return $gallimage_image_data;
	}

	public function getGalleryLayouts($gallimage_id) {
		$gallery_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallimage_to_layout WHERE gallimage_id = '" . (int)$gallimage_id . "'");

		foreach ($query->rows as $result) {
			$gallery_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $gallery_layout_data;
	}

	public function getTotalGallimages() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "gallimage");

		return $query->row['total'];
	}
	
	public function getTotalGalleryByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "gallimage_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}