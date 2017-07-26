<?php
class ModelCatalogOCATestimonialPro extends Model {
	public function CreateDB() {
		$this->db->query("CREATE TABLE IF NOT EXISTS `oca_testimonial` (
			  `testimonial_id` int(11) NOT NULL AUTO_INCREMENT,
			  `customer_id` int(11) NOT NULL,
			  `author` varchar(64) NOT NULL,
			  `image` varchar(255) NOT NULL,
			  `text` text NOT NULL,
			  `status` tinyint(1) NOT NULL DEFAULT '0',
			  `date_added` datetime NOT NULL,
			  `date_modified` datetime NOT NULL,
			  PRIMARY KEY (`testimonial_id`)
			)");
	}

	public function addTestimonial($data) {
		$this->event->trigger('pre.admin.testimonial.add', $data);

		$this->db->query("INSERT INTO oca_testimonial SET author = '" . $this->db->escape($data['author']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "' , status = '" . (int)$data['status'] . "', date_added = NOW()");

		$testimonial_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE oca_testimonial SET image = '" . $this->db->escape($data['image']) . "' WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		}

		$this->event->trigger('post.admin.testimonial.add', $testimonial_id);

		return $testimonial_id;
	}

	public function editTestimonial($testimonial_id, $data) {
		$this->event->trigger('pre.admin.testimonial.edit', $data);

		$this->db->query("UPDATE oca_testimonial SET author = '" . $this->db->escape($data['author']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE oca_testimonial SET image = '" . $this->db->escape($data['image']) . "' WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		}

		$this->event->trigger('post.admin.testimonial.edit', $review_id);
	}

	public function deleteTestimonial($testimonial_id) {
		$this->event->trigger('pre.admin.testimonial.delete', $review_id);

		$this->db->query("DELETE FROM oca_testimonial WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		$this->event->trigger('post.admin.testimonial.delete', $review_id);
	}

	public function getTestimonial($testimonial_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM oca_testimonial WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		return $query->row;
	}

	public function getTestimonials($data = array()) {
		$sql = "SELECT testimonial_id, text, author, status, date_added FROM oca_testimonial WHERE status = '1'";

		if (!empty($data['filter_author'])) {
			$sql .= " AND author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (!empty($data['filter_text'])) {
			$sql .= " AND text LIKE '" . $this->db->escape($data['filter_text']) . "%'";
		}


		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'author',
			'text',
			'status',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY date_added";
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

	public function getTotalTestimonials($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM oca_testimonial WHERE status = '1'";

		if (!empty($data['filter_author'])) {
			$sql .= " AND author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (!empty($data['filter_status'])) {
			$sql .= " AND status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalTestimonialsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM oca_testimonial WHERE status = '0'");

		return $query->row['total'];
	}
}