<?php
class ModelShippingEnhancePickup extends Model {
	function getQuote($address) {
		$this->load->language('shipping/enhancepickup');
	
		
		$method_data = array();
		$status  = 1;
		if ($status) {
			$quote_data = array();
			$enhancepickup_title = $this->config->get('enhancepickup_title');
			$enhancepickup_desc = $this->config->get('enhancepickup_desc');
			$enhancepickup_cost = $this->config->get('enhancepickup_cost');
			$enhancepickup_total = $this->config->get('enhancepickup_total');
			$enhancepickup_geo = $this->config->get('enhancepickup_geo_zone_id');
			for($i=0; $i<count($enhancepickup_title); $i++){
			
				$geo_yes = 1;
				if(isset($enhancepickup_geo[$i]) && $enhancepickup_geo[$i]!=0){
					
					
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$enhancepickup_geo[$i] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
					
					if ($query->num_rows) {
						$geo_yes = 1;
					}else{
						$geo_yes = '';
					}
				}
				
				if($this->cart->getSubTotal() >= $enhancepickup_total[$i] && $geo_yes){
				
					$quote_data['enhancepickup'.$i] = array(
						'code'         => 'enhancepickup.enhancepickup'.$i,
						'title'        => $enhancepickup_title[$i] . ($enhancepickup_desc[$i] ? " ( ".$enhancepickup_desc[$i]." )" : ""),
						'cost'         => $enhancepickup_cost[$i],
						'tax_class_id' => 0,
						'text'         => $this->currency->format($enhancepickup_cost[$i])
					);
		
					$method_data = array(
						'code'       => 'enhancepickup'.$i,
						'title'      => $this->language->get('text_title'),
						'quote'      => $quote_data,
						'sort_order' => $this->config->get('enhancepickup_sort_order'),
						'error'      => false
					);
				
				}
			}
		}
	
		return $method_data;
	}
}
?>