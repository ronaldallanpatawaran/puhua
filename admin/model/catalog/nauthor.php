<?php
class ModelCatalogNauthor extends Model {
	public function addAuthor($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "sb_nauthor SET name = '" . $this->db->escape($data['name']) . "', adminid = '" . $this->db->escape($data['adminid']) . "'");

		$nauthor_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "sb_nauthor SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE nauthor_id = '" . (int)$nauthor_id . "'");
		}

		foreach ($data['nauthor_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "sb_nauthor_description SET nauthor_id = '" . (int)$nauthor_id . "', language_id = '" . (int)$language_id . "', ctitle = '" . $this->db->escape($value['ctitle']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'nauthor_id=" . (int)$nauthor_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if ($this->config->get('config_auto_generate_seo_url')) {
			$query = $this->db->query("SELECT a.nauthor_id, a.name, ad.language_id, l.code FROM " . DB_PREFIX . "sb_nauthor a inner join " . DB_PREFIX . "sb_nauthor_description ad on a.nauthor_id = ad.nauthor_id inner join " . DB_PREFIX . "language l on l.language_id = ad.language_id WHERE a.nauthor_id = '" . (int)$nauthor_id . "'");
						
			foreach ($query->rows as $author_row) {
				if(strlen($author_row['name']) > 1) {
					$slug = generateSlug($author_row['name']);

					$exist_query = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.query = 'nauthor_id=" . $author_row['nauthor_id'] . "'");
					
					if (!$exist_query->num_rows) {
						$exist_keyword = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "'");

						if ($exist_keyword->num_rows) { 
							$exist_keyword_lang = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "' AND " . DB_PREFIX . "url_alias.query <> 'nauthor_id=" . $author_row['nauthor_id'] . "'");

							if ($exist_keyword_lang->num_rows) {
								$slug = generateSlug($author_row['name']).'-'.rand();
							} else {
								$slug = generateSlug($author_row['name']).'-'.$author_row['code'];
							}
						}	
						
						$add_query = "INSERT INTO " . DB_PREFIX . "url_alias (query, keyword) VALUES ('nauthor_id=" . $author_row['nauthor_id'] . "', '" . $slug . "')";

						$this->db->query($add_query);
					}
				}
			}
		}

		$this->cache->delete('nauthor');
	}

	public function editAuthor($nauthor_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "sb_nauthor SET name = '" . $this->db->escape($data['name']) . "', adminid = '" . $this->db->escape($data['adminid']) . "' WHERE nauthor_id = '" . (int)$nauthor_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "sb_nauthor SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE nauthor_id = '" . (int)$nauthor_id . "'");
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_nauthor_description WHERE nauthor_id = '" . (int)$nauthor_id . "'");
		foreach ($data['nauthor_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "sb_nauthor_description SET nauthor_id = '" . (int)$nauthor_id . "', language_id = '" . (int)$language_id . "', ctitle = '" . $this->db->escape($value['ctitle']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'nauthor_id=" . (int)$nauthor_id. "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'nauthor_id=" . (int)$nauthor_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if ($this->config->get('config_auto_generate_seo_url')) {
			$query = $this->db->query("SELECT a.nauthor_id, a.name, ad.language_id, l.code FROM " . DB_PREFIX . "sb_nauthor a inner join " . DB_PREFIX . "sb_nauthor_description ad on a.nauthor_id = ad.nauthor_id inner join " . DB_PREFIX . "language l on l.language_id = ad.language_id WHERE a.nauthor_id = '" . (int)$nauthor_id . "'");
						
			foreach ($query->rows as $author_row) {
				if(strlen($author_row['name']) > 1) {
					$slug = generateSlug($author_row['name']);

					$exist_query = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.query = 'nauthor_id=" . $author_row['nauthor_id'] . "'");
					
					if (!$exist_query->num_rows) {
						$exist_keyword = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "'");

						if ($exist_keyword->num_rows) { 
							$exist_keyword_lang = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "' AND " . DB_PREFIX . "url_alias.query <> 'nauthor_id=" . $author_row['nauthor_id'] . "'");

							if ($exist_keyword_lang->num_rows) {
								$slug = generateSlug($author_row['name']).'-'.rand();
							} else {
								$slug = generateSlug($author_row['name']).'-'.$author_row['code'];
							}
						}	
						
						$add_query = "INSERT INTO " . DB_PREFIX . "url_alias (query, keyword) VALUES ('nauthor_id=" . $author_row['nauthor_id'] . "', '" . $slug . "')";

						$this->db->query($add_query);
					}
				}
			}
		}

		$this->cache->delete('nauthor');
	}

	public function deleteAuthor($nauthor_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_nauthor WHERE nauthor_id = '" . (int)$nauthor_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_nauthor_description WHERE nauthor_id = '" . (int)$nauthor_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'nauthor_id=" . (int)$nauthor_id . "'");

		if ($this->config->get('config_auto_generate_seo_url')) {
			$query = $this->db->query("SELECT a.nauthor_id, a.name, ad.language_id, l.code FROM " . DB_PREFIX . "sb_nauthor a inner join " . DB_PREFIX . "sb_nauthor_description ad on a.nauthor_id = ad.nauthor_id inner join " . DB_PREFIX . "language l on l.language_id = ad.language_id WHERE a.nauthor_id = '" . (int)$nauthor_id . "'");
						
			foreach ($query->rows as $author_row) {
				if(strlen($author_row['name']) > 1) {
					$slug = generateSlug($author_row['name']);

					$exist_query = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.query = 'nauthor_id=" . $author_row['nauthor_id'] . "'");
					
					if (!$exist_query->num_rows) {
						$exist_keyword = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "'");

						if ($exist_keyword->num_rows) { 
							$exist_keyword_lang = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "' AND " . DB_PREFIX . "url_alias.query <> 'nauthor_id=" . $author_row['nauthor_id'] . "'");

							if ($exist_keyword_lang->num_rows) {
								$slug = generateSlug($author_row['name']).'-'.rand();
							} else {
								$slug = generateSlug($author_row['name']).'-'.$author_row['code'];
							}
						}	
						
						$add_query = "INSERT INTO " . DB_PREFIX . "url_alias (query, keyword) VALUES ('nauthor_id=" . $author_row['nauthor_id'] . "', '" . $slug . "')";

						$this->db->query($add_query);
					}
				}
			}
		}

		$this->cache->delete('nauthor');
	}	

	public function getAuthor($nauthor_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'nauthor_id=" . (int)$nauthor_id . "') AS keyword FROM " . DB_PREFIX . "sb_nauthor WHERE nauthor_id = '" . (int)$nauthor_id . "'");

		return $query->row;
	}

	public function getAuthorAdminID($nauthor_id) {
		$query = $this->db->query("SELECT adminid FROM " . DB_PREFIX . "sb_nauthor WHERE nauthor_id = '" . (int)$nauthor_id . "'");
		return $query->row['adminid'];
	}
	
	public function getAuthors() {
		$sql = "SELECT * FROM " . DB_PREFIX . "sb_nauthor";

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getNauthorDescriptions($nauthor_id) {
		$nauthor_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_nauthor_description WHERE nauthor_id = '" . (int)$nauthor_id . "'");
		
		foreach ($query->rows as $result) {
			$nauthor_description_data[$result['language_id']] = array(
				'ctitle'            => $result['ctitle'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}
		
		return $nauthor_description_data;
	}
	public function getTotalAuthors() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "sb_nauthor");

		return $query->row['total'];
	}	
}
?>