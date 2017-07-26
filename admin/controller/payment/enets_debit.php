<?php
class ControllerPaymentEnetsDebit extends Controller
{
    private $version = '1.0.0';
    private $code = 'enets_debit';
    private $extension = 'eNETS';
    private $extension_id = '22837';
    private $purchase_url = 'enets';
    private $error = array();
    public function index()
    {
        $this->load->language('payment/enets_debit');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');
        $domain = isset($this->request->server['HTTP_HOST']) ? $this->request->server['HTTP_HOST'] : (isset($this->request->server['SERVER_NAME']) ? $this->request->server['SERVER_NAME'] : 'example.com');
        if (utf8_strtolower($this->config->get($this->code . '_domain')) != utf8_strtolower($domain)) {
            $setting = $this->model_setting_setting->getSetting($this->code);
            $data    = array(
                $this->code . '_order_id' => '',
                $this->code . '_email' => '',
                $this->code . '_domain' => '',
                $this->code . '_activated_date' => ''
            );
            $this->model_setting_setting->editSetting($this->code, array_merge($setting, $data));
        }
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->request->post[$this->code . '_order_id']       = $this->config->get($this->code . '_order_id');
            $this->request->post[$this->code . '_email']          = $this->config->get($this->code . '_email');
            $this->request->post[$this->code . '_domain']         = $this->config->get($this->code . '_domain');
            $this->request->post[$this->code . '_activated_date'] = $this->config->get($this->code . '_activated_date');
            $this->model_setting_setting->editSetting('enets_debit', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }
        $data['heading_title']          = $this->language->get('heading_title');
        $data['tab_general']            = $this->language->get('tab_general');
        $data['text_edit']              = $this->language->get('text_edit');
        $data['text_enabled']           = $this->language->get('text_enabled');
        $data['text_disabled']          = $this->language->get('text_disabled');
        $data['text_all_zones']         = $this->language->get('text_all_zones');
        $data['entry_test_url']         = $this->language->get('entry_test_url');
        $data['entry_live_url']         = $this->language->get('entry_live_url');
        $data['entry_test_mid']         = $this->language->get('entry_test_mid');
        $data['entry_live_mid']         = $this->language->get('entry_live_mid');
        $data['entry_test_mode']        = $this->language->get('entry_test_mode');
        $data['entry_default_currency'] = $this->language->get('entry_default_currency');
        $data['entry_geo_zone']         = $this->language->get('entry_geo_zone');
        $data['entry_order_status']     = $this->language->get('entry_order_status');
        $data['entry_total']            = $this->language->get('entry_total');
        $data['entry_status']           = $this->language->get('entry_status');
        $data['entry_sort_order']       = $this->language->get('entry_sort_order');
        $data['help_total']             = $this->language->get('help_total');
        $data['button_save']            = $this->language->get('button_save');
        $data['button_cancel']          = $this->language->get('button_cancel');
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        $data['breadcrumbs']   = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('payment/enets_debit', 'token=' . $this->session->data['token'], 'SSL')
        );
        $data['action']        = $this->url->link('payment/enets_debit', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel']        = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
        if (isset($this->request->post['enets_debit_test_url'])) {
            $data['enets_debit_test_url'] = $this->request->post['enets_debit_test_url'];
        } elseif ($this->config->get('enets_debit_test_url')) {
            $data['enets_debit_test_url'] = $this->config->get('enets_debit_test_url');
        } else {
            $data['enets_debit_test_url'] = 'https://test.enets.sg/enets2/enps.do';
        }
        if (isset($this->request->post['enets_debit_live_url'])) {
            $data['enets_debit_live_url'] = $this->request->post['enets_debit_live_url'];
        } elseif ($this->config->get('enets_debit_live_url')) {
            $data['enets_debit_live_url'] = $this->config->get('enets_debit_live_url');
        } else {
            $data['enets_debit_live_url'] = 'https://www.enets.sg/enets2/enps.do';
        }
        if (isset($this->request->post['enets_debit_test_mid'])) {
            $data['enets_debit_test_mid'] = $this->request->post['enets_debit_test_mid'];
        } else {
            $data['enets_debit_test_mid'] = $this->config->get('enets_debit_test_mid');
        }
        if (isset($this->request->post['enets_debit_live_mid'])) {
            $data['enets_debit_live_mid'] = $this->request->post['enets_debit_live_mid'];
        } else {
            $data['enets_debit_live_mid'] = $this->config->get('enets_debit_live_mid');
        }
        if (isset($this->request->post['enets_debit_test_mode'])) {
            $data['enets_debit_test_mode'] = $this->request->post['enets_debit_test_mode'];
        } elseif ($this->config->get('enets_debit_test_mode')) {
            $data['enets_debit_test_mode'] = $this->config->get('enets_debit_test_mode');
        } else {
            $data['enets_debit_test_mode'] = false;
        }
        $this->load->model('localisation/currency');
        $data['currencies'] = $this->model_localisation_currency->getCurrencies();
        if (isset($this->request->post['enets_debit_default_currency'])) {
            $data['enets_debit_default_currency'] = $this->request->post['enets_debit_default_currency'];
        } elseif ($this->config->get('enets_debit_default_currency')) {
            $data['enets_debit_default_currency'] = $this->config->get('enets_debit_default_currency');
        } else {
            $data['enets_debit_default_currency'] = $this->config->get('config_currency');
        }
        $this->load->model('localisation/geo_zone');
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
        if (isset($this->request->post['enets_debit_geo_zone_id'])) {
            $data['enets_debit_geo_zone_id'] = $this->request->post['enets_debit_geo_zone_id'];
        } else {
            $data['enets_debit_geo_zone_id'] = $this->config->get('enets_debit_geo_zone_id');
        }
        if (isset($this->request->post['enets_debit_total'])) {
            $data['enets_debit_total'] = $this->request->post['enets_debit_total'];
        } elseif ($this->config->get('enets_debit_total')) {
            $data['enets_debit_total'] = $this->config->get('enets_debit_total');
        } else {
            $data['enets_debit_total'] = '0.10';
        }
        if (isset($this->request->post['enets_debit_order_status_id'])) {
            $data['enets_debit_order_status_id'] = $this->request->post['enets_debit_order_status_id'];
        } else {
            $data['enets_debit_order_status_id'] = $this->config->get('enets_debit_order_status_id');
        }
        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
        if (isset($this->request->post['enets_debit_status'])) {
            $data['enets_debit_status'] = $this->request->post['enets_debit_status'];
        } else {
            $data['enets_debit_status'] = $this->config->get('enets_debit_status');
        }
        if (isset($this->request->post['enets_debit_sort_order'])) {
            $data['enets_debit_sort_order'] = $this->request->post['enets_debit_sort_order'];
        } else {
            $data['enets_debit_sort_order'] = $this->config->get('enets_debit_sort_order');
        }
        $data['token']          = $this->session->data['token'];
        $data['version']        = $this->version;
        $data['code']           = $this->code;
        $data['extension']      = $this->extension;
        $data['extension_id']   = $this->extension_id;
        $data['purchase_url']   = $this->purchase_url;
        $data['order_id']       = utf8_strtolower($this->config->get($this->code . '_domain')) == utf8_strtolower($domain) ? $this->config->get($this->code . '_order_id') : '';
        $data['email']          = $this->config->get($this->code . '_email');
        $data['domain']         = $this->config->get($this->code . '_domain');
        $data['activated_date'] = $this->config->get($this->code . '_activated_date');
        $data['header']         = $this->load->controller('common/header');
        $data['column_left']    = $this->load->controller('common/column_left');
        $data['footer']         = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('payment/enets_debit.tpl', $data));
    }
    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'payment/' . $this->code)) {
            $this->error['warning'] = $this->language->get('Warning: You do not have permission to modify payment eNETS (Direct Debit)!');
        }
        return !$this->error;
    }
    public function license()
    {
        $json = array();
        if (isset($this->request->post['license_order_id']) && isset($this->request->post['license_email'])) {
            $domain    = isset($this->request->server['HTTP_HOST']) ? $this->request->server['HTTP_HOST'] : (isset($this->request->server['SERVER_NAME']) ? $this->request->server['SERVER_NAME'] : 'example.com');
            $post_data = array(
                'order_id' => $this->request->post['license_order_id'],
                'email' => $this->request->post['license_email'],
                'domain' => $domain
            );
            $curl      = curl_init();
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLINFO_HEADER_OUT, true);
            curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, 'http://license.marketinsg.com/index.php?load=common/home/activatelicense');
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post_data));
            $response = curl_exec($curl);
            $data     = json_decode($response, true);
            if (isset($data['error'])) {
                $json['error'] = $data['error'];
            } elseif (isset($data['success'])) {
                $json['success'] = true;
                $this->load->model('setting/setting');
                $setting = $this->model_setting_setting->getSetting($this->code);
                $data    = array(
                    $this->code . '_order_id' => $post_data['order_id'],
                    $this->code . '_email' => $post_data['email'],
                    $this->code . '_domain' => $post_data['domain'],
                    $this->code . '_activated_date' => date('d M Y H:i:s')
                );
                $this->model_setting_setting->editSetting($this->code, array_merge($setting, $data));
            } else {
                $json['error'] = base64_decode('V2UgYXJlIHVuYWJsZSB0byByZWFjaCB0aGUgbGljZW5zaW5nIHNlcnZlci4gRW5zdXJlIHlvdSBoYXZlIGFuIGludGVybmV0IGNvbm5lY3Rpb24u');
            }
            curl_close($curl);
        }
        $this->response->setOutput(json_encode($json));
    }
    public function revoke()
    {
        $json = array();
        if ($this->user->hasPermission('modify', 'payment/' . $this->code)) {
            $domain    = isset($this->request->server['HTTP_HOST']) ? $this->request->server['HTTP_HOST'] : (isset($this->request->server['SERVER_NAME']) ? $this->request->server['SERVER_NAME'] : 'example.com');
            $post_data = array(
                'order_id' => $this->config->get($this->code . '_order_id'),
                'email' => $this->config->get($this->code . '_email'),
                'domain' => $this->config->get($this->code . '_domain')
            );
            $curl      = curl_init();
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLINFO_HEADER_OUT, true);
            curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, 'http://license.marketinsg.com/index.php?load=common/home/revokelicense');
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post_data));
            $response = curl_exec($curl);
            $data     = json_decode($response, true);
            if (isset($data['error'])) {
                $json['error'] = $data['error'];
            } elseif (isset($data['success'])) {
                $json['success'] = true;
                $this->load->model('setting/setting');
                $setting = $this->model_setting_setting->getSetting($this->code);
                $data    = array(
                    $this->code . '_order_id' => '',
                    $this->code . '_email' => '',
                    $this->code . '_domain' => '',
                    $this->code . '_activated_date' => ''
                );
                $this->model_setting_setting->editSetting($this->code, array_merge($setting, $data));
            } else {
                $json['error'] = base64_decode('V2UgYXJlIHVuYWJsZSB0byByZWFjaCB0aGUgbGljZW5zaW5nIHNlcnZlci4gRW5zdXJlIHlvdSBoYXZlIGFuIGludGVybmV0IGNvbm5lY3Rpb24u');
            }
            curl_close($curl);
        }
        $this->response->setOutput(json_encode($json));
    }
    public function mail()
    {
        $json = array();
        if ($this->user->hasPermission('modify', 'payment/' . $this->code)) {
            if (strlen($this->request->post['mail_name']) < 3 || strlen($this->request->post['mail_name']) > 16) {
                $json['error']['name'] = 'Name must be between 3 and 16 characters';
            }
            if ((strlen($this->request->post['mail_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,15}$/i', $this->request->post['mail_email'])) {
                $json['error']['email'] = 'Email address must be valid!';
            }
            if (strlen($this->request->post['mail_order_id']) < 3 || (int) $this->request->post['mail_order_id'] == 0) {
                $json['error']['order_id'] = 'Order ID must be valid!';
            }
            if (strlen($this->request->post['mail_message']) < 20 || strlen($this->request->post['mail_message']) > 2400) {
                $json['error']['message'] = 'Message must be between 20 and 2400 characters!';
            }
            if (!$json) {
                $subject = '[' . $this->extension . '] Support ' . $this->request->post['mail_name'];
                $message = 'Order ID: ' . $this->request->post['mail_order_id'] . "\n\n";
                $message .= $this->request->post['mail_message'];
                if (version_compare(VERSION, '2.0.2.0', '<')) {
                    $mail = new Mail($this->config->get('config_mail'));
                } else {
                    $mail                = new Mail();
                    $mail->protocol      = $this->config->get('config_mail_protocol');
                    $mail->parameter     = $this->config->get('config_mail_parameter');
                    $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                    $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                    $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                    $mail->smtp_port     = $this->config->get('config_mail_smtp_port');
                    $mail->smtp_timeout  = $this->config->get('config_mail_smtp_timeout');
                }
                $mail->setTo('support@marketinsg.com');
                $mail->setFrom($this->request->post['mail_email']);
                $mail->setSender($this->request->post['mail_name']);
                $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
                $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
                $mail->send();
                $json['success'] = 'You have successfully contacted MarketInSG\'s Support';
            }
        }
        $this->response->setOutput(json_encode($json));
    }
}