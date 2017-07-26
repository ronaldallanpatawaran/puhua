<?php
class ControllerPaymentEnetsCredit extends Controller {
    public function index() {
        $this->language->load('payment/enets_credit');

        $data['button_confirm'] = $this->language->get('button_confirm');
		
        $default_currency = $this->config->get('enets_default_currency_d');
		
        if (!$this->config->get('enets_credit_test_mode')) {
            $data['merchant_id'] = $this->config->get('enets_credit_live_mid');
        } else {
            $data['merchant_id'] = $this->config->get('enets_credit_test_mid');
        }
		
        $data['umapi_type'] = 'lite';

        if (!$this->config->get('enets_credit_test_mode')) {
            $data['action'] = $this->config->get('enets_credit_live_url');
        } else {
            $data['action'] = $this->config->get('enets_credit_test_url');
        }

        $this->load->model('checkout/order');
		
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        $this->load->model('payment/enets_credit');
		
        $data['amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $this->model_payment_enets_credit->getCurrencyValue($this->config->get('enets_credit_default_currency')), false);
        
		$data['reference_no'] = $this->session->data['order_id'];

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/enets.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/enets.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/enets.tpl', $data);
		}
    }
}
?>