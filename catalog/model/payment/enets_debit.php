<?php 
class ModelPaymentEnetsDebit extends Model {
	public function getMethod($address, $total) {
		$this->language->load('payment/enets_debit');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('enets_debit_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('enets_debit_total') > 0 && $this->config->get('enets_debit_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('enets_debit_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'enets_debit',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('enets_debit_sort_order')
			);
		}

		return $method_data;
	}

    public function getCurrencyValue($currency_code) {
        $query = $this->db->query("SELECT value FROM " . DB_PREFIX . "currency WHERE code = '" . $this->db->escape($currency_code) . "'");

        $return_value = 1;
		
        if ($query->num_rows) {
            $return_value = $query->row['value'];
        }

        return $return_value;
    }
}
?>