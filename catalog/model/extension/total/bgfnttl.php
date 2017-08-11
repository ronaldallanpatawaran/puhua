<?php
class ModelExtensiontotalbgfnttl extends Controller {
	private $modpath = '';
 	private $modname = 'bgfnttl';
	private $modssl = '';
	private $modlangid = '';
	private $modstoreid = '';
	private $modgrpid = '';	
 	
	public function __construct($registry) {
		parent::__construct($registry);
 		$this->modpath = (substr(VERSION,0,3)=='2.3') ? 'extension/total/bgfnttl' : 'total/bgfnttl';
  		$this->modssl = (substr(VERSION,0,3)=='2.3' || substr(VERSION,0,3)=='2.2') ? true : 'SSL';
 		$this->modlangid = (int)$this->config->get('config_language_id');
		$this->modgrpid = (int)$this->config->get('config_customer_group_id');
		$this->modstoreid = (int)$this->config->get('config_store_id');
 	}
	
	public function getTotal($total) {
 		$discount_total = 0;
  		
		$return_bgfn_total = $this->checkprod();
		$mod_discount_price = $return_bgfn_total[0];
		$mod_discount_productname = $return_bgfn_total[1];
		$mod_discount_totaltext = $return_bgfn_total[2];
 		
		if($mod_discount_price) {
			// print_r($this->discprice);exit;
  			foreach($mod_discount_price as $key => $discvalue) {
 				$discount_total = $discvalue;
 				if ($discount_total != 0) {					
					if(substr(VERSION,0,3)=='2.3' || substr(VERSION,0,3)=='2.2') { 
						$total['totals'][] = array(
							'code'       => 'bgfnttl',
							'title'      => sprintf($mod_discount_totaltext[$key] , $mod_discount_productname[$key]),
							'value'      => $discount_total,
							'sort_order' => $this->config->get('bgfnttl_sort_order')
						);
 						$total['total'] += $discount_total; 	
					} else {
						$total_data[] = array(
							'code'       => 'bgfnttl',
							'title'      => sprintf($mod_discount_totaltext[$key] , $mod_discount_productname[$key]),
							'value'      => -$discount_total,
							'sort_order' => $this->config->get('bgfnttl_sort_order')
						);
 						$total += $discount_total;
					}
  				} 
			}
		} 	
	}
	
	public function checkprod() { 
		$mod_discount_price = array();
		$mod_discount_productname = array();
		$mod_discount_totaltext = array();
		
		foreach ($this->cart->getProducts() as $product) {	
			$return_bgfn = $this->checkbgfnProductID($product['product_id']);
			if($return_bgfn) {  
 				if($product['quantity'] >= $return_bgfn['buyqty']) {
					$freeqty = floor( ($product['quantity'] / $return_bgfn['buyqty']) * $return_bgfn['getqty']);
					$product['price'] = $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'));
					
					if(!isset($mod_discount_price[$product['product_id']])) {
						if($return_bgfn['disctype'] == 0) {  // 0 = free
							$mod_discount_price[$product['product_id']] = (-$product['price'] * $freeqty);
 						}
						if($return_bgfn['disctype'] == 1) { // percentage
							$mod_discount_price[$product['product_id']] = (-round(($product['price'] * $return_bgfn['discval'])/100,2)* $freeqty);
 						}
						if($return_bgfn['disctype'] == 2) { // fixed amount
							$mod_discount_price[$product['product_id']] = (-$return_bgfn['discval'] * $freeqty);
 						}
 						$mod_discount_productname[$product['product_id']] = $product['name'];
						$mod_discount_totaltext[$product['product_id']] = $return_bgfn['total_text'];
 					} 
				}
 			}
		}
		return array($mod_discount_price, $mod_discount_productname, $mod_discount_totaltext);
	} 
 
	public function checkbgfnProductID($product_id) {
 		if($this->config->get('bgfn_status')) { 
			$bgfn_setting = $this->getbgfn();
 			if($this->config->get('bgfn_status') && $bgfn_setting) { 		
				foreach($bgfn_setting as $modsetting) {
				//echo "<pre>";print_r($modsetting);exit;
					if(isset($modsetting['store']) && in_array($this->modstoreid, $modsetting['store']) && isset($modsetting['customer_group']) && in_array($this->modgrpid, $modsetting['customer_group'])) {
						 
						$flag = false;
						if($modsetting['product'] && in_array($product_id , $modsetting['product'])) {
							$flag = true;  
						}
						if($modsetting['category']) {
							$category_str = implode(",",$modsetting['category']);
							$query = $this->db->query("SELECT count(category_id) as bgfnttl FROM " . DB_PREFIX . "product_to_category where 1 and product_id = '".(int)$product_id."' and FIND_IN_SET(category_id , '".$category_str."') ");
							if(isset($query->row['bgfnttl']) && $query->row['bgfnttl'] > 0) {	
								$flag = true;  
							}
						}	
						if($modsetting['manufacturer']) {
							$manufacturer_str = implode(",",$modsetting['manufacturer']);
							$query = $this->db->query("SELECT count(manufacturer_id) as bgfnttl FROM " . DB_PREFIX . "product where 1 and product_id = '".(int)$product_id."' and FIND_IN_SET(manufacturer_id , '".$manufacturer_str."') ");
							if(isset($query->row['bgfnttl']) && $query->row['bgfnttl'] > 0) {	
								$flag = true; 
							}
						}	
						
						if(! ((isset($modsetting['product']) && $modsetting['product']) || 
							(isset($modsetting['category']) && $modsetting['category']) || 
							(isset($modsetting['manufacturer']) && $modsetting['manufacturer'])) ) {
							$flag = true; 
						}	
						
						if($flag) {
							$return_data['product_id'] = $product_id;
							$return_data['ribbon_text'] = $modsetting['ribbon_text'.$this->modlangid];
							$return_data['total_text'] = $modsetting['total_text'.$this->modlangid];
							$return_data['disctype'] = $modsetting['disctype'];
							$return_data['discval'] = $modsetting['discval'];
							$return_data['buyqty'] = $modsetting['buyqty'];
							$return_data['getqty'] = $modsetting['getqty'];
							$return_data['flag'] = $flag;
							$return_data['modsetting'] = $modsetting;
							return $return_data;
						} 
					}
				}
			} else {
				return false;
			}
		}
	}
	
	private function getbgfn() {
		$setting_data = array();
 		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "bgfn WHERE 1 ");
 		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$setting_data[$result['row']] = $result['value'];
			} else {
				$setting_data[$result['row']] = json_decode($result['value'], true);
			}
		}
 		return $setting_data;	
 	}  
		
	protected function setvalue($postfield) {
		return $this->config->get($postfield);
	}
}