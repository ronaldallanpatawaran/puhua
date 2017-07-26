<?php
//==============================================================================
// Form Builder Pro v210.2
// 
// Author: Clear Thinking, LLC
// E-mail: johnathan@getclearthinking.com
// Website: http://www.getclearthinking.com
// 
// All code within this file is copyright Clear Thinking, LLC.
// You may not copy or reuse code within this file without written permission.
//==============================================================================

class ControllerModuleFormBuilder extends Controller {
	private $type = 'module';
	private $name = 'form_builder';
	private $copy = 'information';
	
	public function index($settings) {
		if (empty($settings) || empty($settings['status'])) return;
		
		$data['type'] = $this->type;
		$data['name'] = $this->name;
		
		$data['language'] = $this->session->data['language'];
		$data = array_merge($data, $this->load->language($this->type . '/' . $this->copy));
		
		if (version_compare(VERSION, '2.0.1', '<')) {
			$modules = $this->config->get($this->name . '_module');
			foreach ($modules as $module_id => $module) {
				if ($module == $settings) {
					$settings['module_id'] = $module_id;
					break;
				}
			}
		} else {
			$module_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "module WHERE setting = '" . $this->db->escape(version_compare(VERSION, '2.1', '<') ? serialize($settings) : json_encode($settings)) . "'");
			$settings['module_id'] = $module_query->row['module_id'];
		}
		
		$data['settings'] = $settings;
		$data['total_rows'] = 0;
		$data['fields'] = array();
		
		$layouts = array();
		foreach (explode(',', $settings['layout']) as $layout) {
			$pair = explode(':', $layout);
			$layouts[$pair[0]] = $pair[1];
		}
		
		foreach ($settings['fields'] as $field) {
			if (empty($layouts[$field['key']])) continue;
			
			foreach ($field as &$value) {
				$value = $this->replaceShortcodes($value);
			}
			
			$layout = explode('-', $layouts[$field['key']]);
			if ($layout[0] == 1 && $field['type'] != 'hidden') {
				$data['total_rows'] += $layout[3];
			}
			
			$field['x']		= $layout[0];
			$field['y']		= $layout[1];
			$field['cols']	= $layout[2];
			$field['rows']	= $layout[3];
			
			$data['fields'][] = $field;
		}
		
		$template = (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/' . $this->type . '/' . $this->name . '.tpl')) ? $this->config->get('config_template') : 'default';
		$template_file = $template . '/template/' . $this->type . '/' . $this->name . '.tpl';
		
		if (version_compare(VERSION, '2.0', '<')) {
			$data['site_key'] = $settings['recaptcha_site_key'];
			$this->data = $data;
			$this->template = $template_file;
			$this->render();
		} else {
			$data['site_key'] = $this->config->get('config_google_captcha_public');
			return $this->load->view($template_file, $data);
		}
	}
	
	//==============================================================================
	// Private functions
	//==============================================================================
	private function replaceShortcodes($text) {
		foreach ($this->request->get as $key => $value) {
			$text = str_replace('[' . $key . ']', urldecode($value), $text);
			if ($key != 'product_id') continue;
			
			$this->load->model('catalog/product');
			$product_info = $this->model_catalog_product->getProduct($value);
			if (!$product_info) continue;
			
			foreach ($product_info as $k => $v) {
				$text = str_replace('[product_' . $k . ']', $v, $text);
			}
		}
		if ($text == '[url]') {
			$text = HTTP_SERVER . $_SERVER['REQUEST_URI'];
		} else {
			$text = preg_replace('/\[.*?\]/', '', $text);
		}
		return html_entity_decode($text, ENT_QUOTES, 'UTF-8');
	}
	
	//==============================================================================
	// Public functions
	//==============================================================================
	public function upload() {
		if (version_compare(VERSION, '2.0.1', '<')) {
			$modules = $this->config->get($this->name . '_module');
			$form = $modules[$this->request->get['module_id']];
		} else {
			$this->load->model('extension/module');
			$form = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
		
		$json = array();
		$language = $this->session->data['language'];
		
		if (!empty($this->request->files['file']['name'])) {
			$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));
			if ((strlen($filename) < 3) || (strlen($filename) > 128)) {
				$json['error'] = $form['error_file_name_' . $language];
			}
			$allowed = explode(',', preg_replace('/[\.\s+]/', '', $form['file_extensions']));
			if (!in_array(substr($filename, strrpos($filename, '.') + 1), $allowed)) {
				$json['error'] = $form['error_file_ext_' . $language];
       		}
			if ($this->request->files['file']['size'] > $form['file_size']*1000) {
				$json['error'] = $form['error_file_size_' . $language];
			}
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $form['error_file_upload_' . $language];
			}
		} else {
			$json['error'] = $form['error_file_upload_' . $language];
		}
		
		if (empty($json)) {
			if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
				$file = basename($filename) . '.' . md5(mt_rand());
				move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $file);
				$this->load->library('encryption');
				$encryption = new Encryption($this->config->get('config_encryption'));
				$json['file'] = $encryption->encrypt($file);
				$json['name'] = str_replace(strrchr(basename($file), '.'), '', basename($file)); 
			}
		} else {
			$json['name'] = $filename;
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function submit() {
		if (!$this->config->get($this->name . '_status')) return;
		
		if (version_compare(VERSION, '2.0.1', '<')) {
			$modules = $this->config->get($this->name . '_module');
			$form = $modules[$this->request->get['module_id']];
		} else {
			$this->load->model('extension/module');
			$form = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
		
		$language = $this->session->data['language'];
		$store_name = $this->config->get('config_name');
		if (is_array($store_name)) $store_name = array_shift($store_name);
		
		// Check captcha
		foreach ($form['fields'] as $field) {
			if ($field['type'] == 'captcha') {
				$secret_key = (version_compare(VERSION, '2.0', '<')) ? $form['recaptcha_secret_key'] : $this->config->get('config_google_captcha_secret');
				$recaptcha = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secret_key) . '&response=' . $this->request->get['captcha'] . '&remoteip=' . $this->request->server['REMOTE_ADDR']), true);
				if (!$recaptcha['success']) {
					echo $form['error_captcha_' . $language];
					return;
				}
			}
		}
		
		// Set up mail form
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		
		if (version_compare(VERSION, '2.0', '<')) {
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');
		} else {
			$mail->smtp_hostname = $this->config->get('config_smtp_host');
			$mail->smtp_username = $this->config->get('config_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_smtp_timeout');
		}
		
		// Format responses
		$responses = array();
		$customer_emails = array();
		$files = array();
		$admin_response_list = '';
		$customer_response_list = '';
		
		$replace = array(
			'[store_name]',
			'[store_url]',
			'[store_owner]',
			'[store_address]',
			'[store_email]',
			'[store_telephone]',
			'[store_fax]',
			'[customer_ip]',
			'[current_date]',
			'[current_time]',
			'[form_name]',
		);
		$with = array(
			$store_name,
			($this->config->get('config_url') ? $this->config->get('config_url') : HTTP_SERVER),
			$this->config->get('config_name'),
			$this->config->get('config_address'),
			$this->config->get('config_email'),
			$this->config->get('config_telephone'),
			$this->config->get('config_fax'),
			$this->db->escape($this->request->server['REMOTE_ADDR']),
			date($this->language->get('date_format_short')),
			date($this->language->get('time_format')),
			$form['heading_' . $language],
		);
		
		foreach ($form['fields'] as $field) {
			if (in_array($field['type'], array('captcha', 'html', 'submit'))) continue;
			
			$response = (isset($this->request->post[$field['key']])) ? $this->request->post[$field['key']] : '';
			$responses[$field['key']] = ($field['type'] == 'file') ? array() : $response;
			
			if ($field['type'] == 'email' && !empty($response)) {
				$customer_emails[] = trim($response);
			} elseif ($field['type'] == 'file' && !empty($response)) {
				$filename_array = array();
				foreach ($response as $encrypted_file) {
					$this->load->library('encryption');
					$encryption = new Encryption($this->config->get('config_encryption'));
					$decrypted_file = $encryption->decrypt($encrypted_file);
					
					$filename = str_replace(strrchr(basename($decrypted_file), '.'), '', basename($decrypted_file));
					$filename_array[] = $filename;
					$responses[$field['key']][] = $decrypted_file;
					
					if (file_exists(DIR_DOWNLOAD . $decrypted_file)) {
						copy(DIR_DOWNLOAD . $decrypted_file, DIR_CACHE . $filename);
						$mail->addAttachment(DIR_CACHE . $filename);
						$files[] = DIR_CACHE . $filename;
					}
				}
				$response = $filename_array;
			}
			
			$response_string = (is_array($response)) ? nl2br(implode(', ', $response)) : nl2br($response);
			
			$replace[] = '[' . $field['key'] . ']';
			$with[] = $response_string;
			
			$field_title = strip_tags(html_entity_decode($field['title_' . $language], ENT_QUOTES, 'UTF-8'));
			$response_list_line = '<tr><td style="white-space: nowrap"><strong>' . $field_title . (strpos($field_title, ':') === false ? ':' : '') . '</strong></td> <td>' . $response_string . '</td></tr>' . "\n";
			$admin_response_list .= $response_list_line;
			if ($field['type'] != 'hidden' || !empty($field['email'])) {
				$customer_response_list .= $response_list_line;
			}
		}
		
		// Put together cart contents
		$products = $this->cart->getProducts();
		if (strpos($form['admin_message_' . $language], '[cart_contents]') && !empty($products)) {
			$cart_contents = '<table><tr><td style="white-space: nowrap"><strong>Cart Contents:</strong></td> <td>';
			
			foreach ($products as $product) {
				$options_text = '';
				if (!empty($product['option'])) {
					$options = array();
					foreach ($product['option'] as $option) {
						$options[] = $option['name'] . ': ' . $option[version_compare(VERSION, '2.0', '<') ? 'option_value' : 'value'];
					}
					$options_text = '(' . implode(', ', $options) . ')';
				}
				
				$product_text = '- ' . $product['name'] . $options_text . ' x ' . $product['quantity'] . ': ' . $this->currency->format($product['total']) . '<br />' . "\n";
				$cart_contents .= $product_text;
				$responses['CartContents'] .= $product_text;
			}
			
			if ($this->cart->countProducts() > 1) {
				$cart_contents .= '<b>Total: ' . $this->currency->format($this->cart->getSubTotal()) . '</b>';
			}
			$cart_contents .= '</td></tr></table>' . "\n";
			
			$replace[] = '[cart_contents]';
			$with[] = $cart_contents;
		}
		
		// Record response into database
		if ($form['record_responses']) {
			$this->db->query("
				INSERT INTO " . DB_PREFIX . "form_builder_response SET
				module_id = " . (int)$this->request->get['module_id'] . ",
				customer_id = " . (int)$this->customer->getId() . ",
				date_added = NOW(),
				ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "',
				response = '" . $this->db->escape(serialize($responses)) . "',
				readable_response = '" . $this->db->escape(strip_tags($admin_response_list)) . "'
			");
		}
		
		// Send out e-mails
		$admin_emails = array_map('trim', explode(',', $form['admin_email']));
		$html = html_entity_decode($form['admin_message_' . $language], ENT_QUOTES, 'UTF-8');
		$html = str_replace($replace, $with, $html);
		$html = str_replace('[form_responses]', '<table>' . $admin_response_list . '</table>', $html);
		
		$mail->setFrom(!empty($customer_emails) ? $customer_emails[0] : $admin_emails[0]);
		$mail->setSender(!empty($customer_emails) ? $customer_emails[0] : str_replace(array(',', '&'), array('', 'and'), html_entity_decode($store_name, ENT_QUOTES, 'UTF-8')));
		$mail->setSubject(str_replace($replace, $with, $form['admin_subject_' . $language]));
		$mail->setHtml($html);
		$mail->setText(strip_tags($html));
		
		foreach ($admin_emails as $email) {
			$mail->setTo($email);
			$mail->send();
		}
		
		if (!empty($customer_emails) && $form['customer_email']) {
			$html = html_entity_decode($form['customer_message_' . $language], ENT_QUOTES, 'UTF-8');
			$html = str_replace($replace, $with, $html);
			$html = str_replace('[form_responses]', '<table>' . $customer_response_list . '</table>', $html);
			
			$mail->setFrom($admin_emails[0]);
			$mail->setSender(str_replace(array(',', '&'), array('', 'and'), html_entity_decode($store_name, ENT_QUOTES, 'UTF-8')));
			$mail->setSubject(str_replace($replace, $with, $form['customer_subject_' . $language]));
			$mail->setHtml($html);
			$mail->setText(strip_tags($html));
			
			foreach ($customer_emails as $email) {
				$mail->setTo($email);
				$mail->send();
			}
		}
		
		// Destroy files
		foreach ($files as $file) {
			if (file_exists($file)) unlink($file);
		}
		
		echo 'success';
	}
}
?>