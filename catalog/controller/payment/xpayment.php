<?php

class ControllerPaymentXpayment extends Controller {

	public function index() {

		  $this->language->load('payment/xpayment');
		  $this->load->model('checkout/order');
		
	      $data['button_confirm'] = $this->language->get('button_confirm');
		
		  $language_id=$this->config->get('config_language_id');
		  $payment_method=$this->session->data['payment_method']['code'];
		  
		  $xpayment=$this->config->get('xpayment');
		   if($xpayment) {
		    $xpayment=unserialize(base64_decode($xpayment));
		  }
		  
		  if(!isset($xpayment['name']))$xpayment['name']=array();
		  if(!is_array($xpayment['name']))$xpayment['name']=array();

          $redirect=''; 
          $redirect_type=''; 
		  $xpayment_instruction='';
		  $xpayment_name='';
		  $success='';
                   
          foreach($xpayment['name'] as $no_of_tab=>$names){
              
               if($payment_method=='xpayment'.'.xpayment'.$no_of_tab){
              
                  if(!is_array($names))$names=array();
		
		 	      if(!isset($xpayment['instruction'][$no_of_tab]))$xpayment['instruction'][$no_of_tab]=array();
		 	      if(!is_array($xpayment['instruction'][$no_of_tab]))$xpayment['instruction'][$no_of_tab]=array();
		 	      
		 	      $redirect=isset($xpayment['redirect'][$no_of_tab])?$xpayment['redirect'][$no_of_tab]:'';
		 	      $redirect_type=isset($xpayment['redirect_type'][$no_of_tab])?$xpayment['redirect_type'][$no_of_tab]:'post';
		 	  
		 	      $xpayment_name=$names[$language_id];
		 	      $xpayment_instruction=$xpayment['instruction'][$no_of_tab][$language_id];
		 	      $success=isset($xpayment['success'][$no_of_tab])?$xpayment['success'][$no_of_tab]:'';
		 	      break;
		 	   }
              
          }
		  
		  
		  $order_id=$this->session->data['order_id'];
          $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
          $amount =$this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']);
		  
		  $placeholder=array('{orderId}','{orderTotal}');
		  $replacer=array($order_id,$amount);
		  $xpayment_instruction=str_replace($placeholder,$replacer,$xpayment_instruction);
		  
		  if($success) $success=str_replace($placeholder,$replacer,htmlspecialchars_decode($success));
		  
		  $form_data=array('orderId'=>$order_id,'amount'=>$this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'],false));
		  
		  
		  
		
		  $data['form_data'] = $form_data;
		  $data['redirect'] = $redirect;
		  $data['redirect_type'] = strtoupper($redirect_type);
		  $data['xpayment_instruction'] = html_entity_decode($xpayment_instruction);
		  $data['xpayment_name'] = html_entity_decode($xpayment_name);
		  $data['continue'] = ($success)?$success:$this->url->link('checkout/success');
	
		   if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/xpayment.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/xpayment.tpl', $data);
		   } else {
			return $this->load->view('default/template/payment/xpayment.tpl', $data);
		   }
	  
	}


	public function confirm() {
		  
		  $this->load->model('checkout/order');
	
		  $payment_method=$this->session->data['payment_method']['code'];
		  
		  $xpayment=$this->config->get('xpayment');
		  if($xpayment) {
		    $xpayment=unserialize(base64_decode($xpayment));
		  }
		  
		  $callback='';
		  $order_status_id=0;
		  
		  if(!isset($xpayment['name']))$xpayment['name']=array();
		  if(!is_array($xpayment['name']))$xpayment['name']=array();

                
          foreach($xpayment['name'] as $no_of_tab=>$names){
              
               if($payment_method=='xpayment'.'.xpayment'.$no_of_tab){
            
		 	      $order_status_id=$xpayment['order_status_id'][$no_of_tab];
		 	      $callback=$xpayment['callback'][$no_of_tab];
		 	      break;
		 	   }
              
          }
				
		$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $order_status_id,'',true);
		
		if($callback){
		  $ch = curl_init();
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_URL, $callback);
          $return = curl_exec($ch);
          curl_close($ch);
        }
	}

}

?>