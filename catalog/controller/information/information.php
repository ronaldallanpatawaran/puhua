<?php
class ControllerInformationInformation extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('information/information');
		$this->load->model('design/banner');
		$this->load->model('catalog/information');

		$data['information_id'] = isset($_GET['information_id']) && $_GET['information_id'] != "" ? $_GET['information_id'] : "";

		$data['company_profile_active'] = "";
		$data['our_benefits_active'] = "";
		$data['certifications_active'] = "";

		if($data['information_id'] == 8){
			$data['company_profile_active'] = "active";
		}else if($data['information_id'] == 9){
			$data['our_benefits_active'] = "active";
		}else if($data['information_id'] == 10){
			$data['certifications_active'] = "active";
		}

		$data['contact_url'] = $this->url->link('information/contact');
		$data['company_profile'] = $this->url->link('information/information&information_id=8');
		$data['our_benefits'] = $this->url->link('information/information&information_id=9');
		$data['certifications'] = $this->url->link('information/information&information_id=10');

		$data['text_company_profile'] = $this->language->get('text_company_profile');
		$data['text_our_benefits'] = $this->language->get('text_our_benefits');
		$data['text_certifications'] = $this->language->get('text_certifications');

		$career_information_id = 7;

		$data['breadcrumbs'] = array();
		$data['career'] = $this->url->link('information/information&information_id='. $career_information_id);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		if($information_id == 8){
			$this->load->model('catalog/oca_testimonial');
			$this->load->model('tool/image');

			$data['text_testimonials'] 	= $this->language->get('text_testimonials');
			$data['text_see_more']		= $this->language->get('text_see_more');
			$data['company_timeline']	= $this->model_design_banner->getBanner(13);
			$data['company_clients'] 	= $this->model_design_banner->getBanner(14);
			$data['testimonials'] 		= array();

			$data['testimonial_link']	= $this->url->link('information/testimonial');

			$filter_data = array(
				'sort'               => 'p.sort_order',
				'order'              => 'DESC',
				'start'              => 0,
				'limit'              => 6
			);

			$testimonial_total = $this->model_catalog_oca_testimonial->getTotalTestimonials($filter_data);

			$results = $this->model_catalog_oca_testimonial->getTestimonials($filter_data);
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], 120 , 120);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 120 , 120);
				}

				$data['testimonials'][] = array(
					'testimonial_id'  => $result['testimonial_id'],
					'thumb'           => $image,
					'author'          => $result['author'],
					'text'            =>  html_entity_decode($result['text'], ENT_QUOTES, 'UTF-8'),
					'date_added'	  => date('Y-m-d', strtotime($result['date_added']))
				);
			}

		}


		if($information_id == $career_information_id){

			$this->load->language('information/contact');
			$data['banner'] = $this->load->controller('banner/contact');

			$data['heading_title'] = $this->language->get('heading_title');

			$data['geocode'] = "";	
			$data['text_location'] = $this->language->get('text_location');
			$data['text_store'] = $this->language->get('text_store');
			$data['text_contact'] = $this->language->get('text_contact');
			$data['text_address'] = $this->language->get('text_address');
			$data['text_email'] = $this->language->get('text_email');
			$data['text_telephone'] = $this->language->get('text_telephone');
			$data['text_fax'] = $this->language->get('text_fax');
			$data['text_open'] = $this->language->get('text_open');
			$data['text_comment'] = $this->language->get('text_comment');
			$data['text_career'] = $this->language->get('text_career');
			$data['text_contact_details'] = $this->language->get('text_contact_details');
			$data['text_office_address'] = $this->language->get('text_office_address');
			$data['text_factory_address'] = $this->language->get('text_factory_address');
			$data['text_china_branch'] = $this->language->get('text_china_branch');
			$data['text_malaysia_branch'] = $this->language->get('text_malaysia_branch');
			$data['text_attachment'] = $this->language->get('text_attachment');

			$data['locations'] 		= "";

			$data['entry_name'] 	= $this->language->get('entry_name');
			$data['entry_email'] 	= $this->language->get('entry_email');
			$data['entry_contact'] 	= $this->language->get('entry_contact');
			$data['entry_enquiry'] 	= $this->language->get('entry_enquiry');

			$data['store'] 			= $this->config->get('config_name');
			$data['address'] 		= nl2br($this->config->get('config_address'));
			$data['config_email'] 	= $this->config->get('config_email');
			$data['geocode'] 		= html_entity_decode($this->config->get('config_geocode'), ENT_QUOTES, 'UTF-8');
			$data['telephone'] = $this->config->get('config_telephone');
			$data['fax'] = $this->config->get('config_fax');
			$data['open'] = nl2br($this->config->get('config_open'));
			$data['comment'] = $this->config->get('config_comment');

			$data['contact_url'] = $this->url->link('information/contact');
			$data['company_profile'] = $this->url->link('information/information&information_id=8');
			$data['our_benefits'] = $this->url->link('information/information&information_id=9');
			$data['certifications'] = $this->url->link('information/information&information_id=10');

			if (isset($this->request->post['name'])) {
				$data['name'] = $this->request->post['name'];
			} else {
				$data['name'] = $this->customer->getFirstName();
			}

			if (isset($this->request->post['email'])) {
				$data['email'] = $this->request->post['email'];
			} else {
				$data['email'] = $this->customer->getEmail();
			}

			if (isset($this->request->post['contact'])) {
				$data['contact'] = $this->request->post['contact'];
			} else {
				$data['contact'] = $this->customer->getTelephone();
			}

			if (isset($this->request->post['enquiry'])) {
				$data['enquiry'] = $this->request->post['enquiry'];
			} else {
				$data['enquiry'] = '';
			}

			if ($this->config->get('config_google_captcha_status')) {
				$this->document->addScript('https://www.google.com/recaptcha/api.js');

				$data['site_key'] = $this->config->get('config_google_captcha_public');
			} else {
				$data['site_key'] = '';
			}

			$data['button_submit'] = $this->language->get('button_submit');

			
			$data['action'] = $this->url->link('information/information&information_id='. $career_information_id);


			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->AddAttachment($_FILES['attachment']['tmp_name']);
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

				$mail->setTo($this->config->get('config_email'));
				$mail->setFrom($this->request->post['email']);
				$mail->setSender(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'));
				$mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name']), ENT_QUOTES, 'UTF-8'));

				$message  = $this->language->get('entry_name') . ': ' . $this->request->post['name'] . "\n";
				$message .= $this->language->get('entry_email') . ': ' . $this->request->post['email'] . "\n";
				$message .= $this->language->get('entry_contact') . ': ' . $this->request->post['contact'] . "\n";
				$message .= $this->language->get('entry_enquiry') . ': ' . $this->request->post['enquiry'];
				
				$mail->setText($message);
				$mail->send();

				// Send to additional alert emails
				$emails = explode(',', $this->config->get('config_mail_alert'));

				foreach ($emails as $email) {
					if ($email && preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)) {
						$mail->setTo($email);
						$mail->send();
					}
				}

				$this->response->redirect($this->url->link('information/contact/success'));
			}


			if (isset($this->error['name'])) {
				$data['error_name'] = $this->error['name'];
			} else {
				$data['error_name'] = '';
			}

			if (isset($this->error['email'])) {
				$data['error_email'] = $this->error['email'];
			} else {
				$data['error_email'] = '';
			}

			if (isset($this->error['contact'])) {
				$data['error_contact'] = $this->error['contact'];
			} else {
				$data['error_contact'] = '';
			}

			if (isset($this->error['enquiry'])) {
				$data['error_enquiry'] = $this->error['enquiry'];
			} else {
				$data['error_enquiry'] = '';
			}

			if (isset($this->error['captcha'])) {
				$data['error_captcha'] = $this->error['captcha'];
			} else {
				$data['error_captcha'] = '';
			}

			if (isset($this->error['attachment'])) {
				$data['error_attachment'] = $this->error['attachment'];
			} else {
				$data['error_attachment'] = '';
			}


			}

		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {
			$this->document->setTitle($information_info['meta_title']);
			$this->document->setDescription($information_info['meta_description']);
			$this->document->setKeywords($information_info['meta_keyword']);

			$data['breadcrumbs'][] = array(
				'text' => $information_info['title'],
				'href' => $this->url->link('information/information', 'information_id=' .  $information_id)
			);

			$data['heading_title'] = $information_info['title'];

			$data['button_continue'] = $this->language->get('button_continue');

			$data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');

			$data['continue'] = $this->url->link('common/home');

			$data['common_banner'] = $this->load->controller('banner/about');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['content_middle'] = $this->load->controller('common/content_middle');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/information.tpl')) {
				if($career_information_id == $information_id){
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/career.tpl', $data));
				}else{
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/information.tpl', $data));
				}

			} else {
				if($career_information_id == $information_id){
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/career.tpl', $data));
				}else{
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/information.tpl', $data));
				}
			}
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('information/information', 'information_id=' . $information_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['common_banner'] = $this->load->controller('banner/about');	
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				if($career_information_id == $information_id){
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/career.tpl', $data));
				}else{
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/information.tpl', $data));
				}
			} else {
				if($career_information_id == $information_id){
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/career.tpl', $data));
				}else{
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/information.tpl', $data));
				}
			}
		}
	}

	public function agree() {
		$this->load->model('catalog/information');

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		$output = '';

		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {
			$output .= html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
		}

		$this->response->setOutput($output);
	}

	public function success() {
		$this->load->language('information/contact');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/contact')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_message'] = $this->language->get('text_success');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

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

	protected function validate() {
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
			$this->error['name'] = $this->language->get('error_name');

		}

		if (!preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if (empty($this->request->post['contact'])) {
			$this->error['contact'] = $this->language->get('error_contact');
		}

		if ($this->request->post['attachment']) {
			$extensions = array('');
			if($_FILES['attachment']){
				
			}
			$this->error['attachment'] = $this->language->get('error_attachment');
		}

		if ((utf8_strlen($this->request->post['enquiry']) < 10) || (utf8_strlen($this->request->post['enquiry']) > 3000)) {
			$this->error['enquiry'] = $this->language->get('error_enquiry');
		}

		if ($this->config->get('config_google_captcha_status')) {
			$recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($this->config->get('config_google_captcha_secret')) . '&response=' . $this->request->post['g-recaptcha-response'] . '&remoteip=' . $this->request->server['REMOTE_ADDR']);

			$recaptcha = json_decode($recaptcha, true);

			if (!$recaptcha['success']) {
				$this->error['captcha'] = $this->language->get('error_captcha');
			}
		}

		return !$this->error;
	}
}