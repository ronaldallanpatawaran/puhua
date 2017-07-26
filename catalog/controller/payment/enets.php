<?php
class ControllerPaymentEnets extends Controller {
    public function success() {
        if (isset($this->request->get['status']) && $this->request->get['status'] == 'succ') {
            $error_code = isset($this->request->get['errorCode']) ? $this->request->get['errorCode'] : '';
            $payment_type = isset($this->request->get['payment']) ? $this->request->get['payment'] : '';
            $merchant_id = isset($this->request->get['mid']) ? $this->request->get['mid'] : '';
            $txn_ref = isset($this->request->get['txnRef']) ? $this->request->get['txnRef'] : '';
            $success_confirm = false;

            $this->load->model('checkout/order');

            $this->model_checkout_order->confirm($txn_ref, $this->config->get('config_order_status_id'));

            if ($payment_type == 'Credit' && $error_code == '00' && ($merchant_id == $this->config->get('enets_credit_live_mid') || $merchant_id == $this->config->get('enets_credit_test_mid'))) {
                $success_confirm = true;
            } elseif ($payment_type == 'Debit' && strpos($error_code, '_000000') !== false && ($merchant_id == $this->config->get('enets_debit_live_mid') || $merchant_id == $this->config->get('enets_debit_test_mid'))) {
                $success_confirm = true;
            }

            $message = '';
			
			unset($this->request->get['route']);

            foreach ($this->request->get as $key => $value) {
				$message .= $key . ': ' . $value;
			}

            if ($success_confirm) {
                if ($payment_type == 'Credit') {
                    $this->model_checkout_order->addOrderHistory($txn_ref, $this->config->get('enets_credit_order_status_id'), $message, true);
                } elseif ($payment_type == 'Debit') {
                    $this->model_checkout_order->addOrderHistory($txn_ref, $this->config->get('enets_debit_order_status_id'), $message, true);
                }
            } else {
                $this->model_checkout_order->addOrderHistory($txn_ref, $this->config->get('config_order_status_id'), $message, true);
            }

            $this->redirect($this->url->link('checkout/success'));
        }
    }

    public function failure() {
        $payment_type = isset($this->request->get['payment']) ? $this->request->get['payment'] : '';

        if ($payment_type == 'Debit') {
            $this->language->load('payment/enets_debit');
        } else {
            $this->language->load('payment/enets_credit');
        }

        $this->document->setTitle($this->language->get('heading_title'));
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_checkout'),
			'href'      => $this->url->link('checkout/checkout', '', 'SSL')
		);
		
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/enets', '', 'SSL')
		);

        $data['heading_title'] = $this->language->get('heading_title');
		
        $data['text_message'] = $this->language->get('text_payment_failed');
		
        $data['button_continue'] = $this->language->get('button_continue');

        $data['continue'] = $this->url->link('checkout/cart');

        $data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/success.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/success.tpl', $data));
		}
    }

    public function cancel() {
        $this->response->redirect($this->url->link('checkout/checkout', '', 'SSL'));
    }

    public function notify() {
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->log->write('ENETS NOTIFICATION: ' . print_r($this->request->post, true));
        }
    }
}
?>