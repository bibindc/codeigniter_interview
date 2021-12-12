<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Login_model');
		$this->load->model('Data_model');
		$this->load->library('form_validation');
		$this->load->helper(array(
			'form',
			'url',
			'captcha'
		));
	}

	public function index()
	{
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('user_type');
		$this->session->unset_userdata('captchaWord');

		$vals = array(
			'img_path'      => 'captcha/',
			'img_url'       => base_url() . 'captcha/',
			'font' => 'system/fonts/texb.ttf',
			'img_width' => '160',
			'img_height' => 50,
			'word_length' => 8,
			'font_size' => 18
		);

		$cap = create_captcha($vals);
		$this->session->set_userdata('captchaWord', $cap['word']);

		$this->load->view('login', ['catch_img' => $cap['image']]);
	}
	public function register()
	{
		$countries = $this->Data_model->getCountries();
		$data = array('countries' => $countries);
		$this->load->view('register', $data);
	}

	public function verifyacoountvaimail($hash)
	{
		$check = $this->Login_model->auth_user_mail($hash);
		if ($check) {
			$data = array(
				'US_Status' => 2
			);
			$save = $this->Data_model->updateUser($check[0]->US_Id, $data);
		} else {
			$this->load->view('login', ['error' => 'Not Verified']);
		}
	}
	public function do_login()
	{
		$config = array(
			array(
				'field' => 'login_email',
				'label' => ' Email',
				'rules' => 'required|valid_email'
			),
			array(
				'field' => 'login_pass',
				'label' => 'Password',
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() === FALSE) {
			$this->index();
		} else {
			$word = $this->session->userdata('captchaWord');
			$capword = $this->input->post('login_captcha');
			if ($word != $capword) {
				$this->form_validation->set_message('check_database', 'Invalid captcha');
				return false;
			} else {
				$check = $this->Login_model->auth_user();
				if ($check) {
					$this->session->set_userdata('logged_in', $check[0]->US_Id);
					$this->session->set_userdata('user_type', $check[0]->US_Type);
					if ($check[0]->US_Type == 1)
						redirect('admin');
					else {
						$this->session->set_userdata('user_subscribe', $check[0]->US_Subscription);
						redirect('customer');
					}
				} else {
					$this->load->view('login', ['error' => 'Incorrect login details!!']);
				}
			}
		}
	}
	public function do_signup()
	{
		$config = array(
			array(
				'field' => 'first_name',
				'label' => 'First name',
				'rules' => 'required'
			),
			array(
				'field' => 'last_name',
				'label' => 'Last name',
				'rules' => 'required'
			),
			array(
				'field' => 'user_email',
				'label' => ' Email',
				'rules' => 'required|valid_email'
			),
			array(
				'field' => 'user_pass',
				'label' => 'Password',
				'rules' => 'required'
			),
			array(
				'field' => 'country',
				'label' => 'Country',
				'rules' => 'required'
			),
			array(
				'field' => 'subscription',
				'label' => 'Subscription',
				'rules' => 'required'
			),
			array(
				'field' => 'phone',
				'label' => 'Phone',
				'rules' => 'required|regex_match[\^(((\+44\s?\d{4}|\(?0\d{4}\)?)\s?\d{3}\s?\d{3})|((\+44\s?\d{3}|\(?0\d{3}\)?)\s?\d{3}\s?\d{4})|((\+44\s?\d{2}|\(?0\d{2}\)?)\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$\]'
			),
			array(
				'field' => 'dob',
				'label' => 'DOB',
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() === FALSE) {
			$this->register();
		} else {
			$data = array(
				"US_FirstName" => $this->input->post('first_name'),
				"US_LastName" => $this->input->post('last_name'),
				"US_Dob" => date('Y-m-d', strtotime($this->input->post('dob'))),
				"US_Email" => $this->input->post('user_email'),
				"US_Password" => md5("'" . $this->input->post('user_pass') . "'"),
				"US_Type" => 2,
				"US_Status" => 1,
				"US_Country" => $this->input->post('country'),
				"US_Phone" => $this->input->post('phone'),
				"US_Subscription" => $this->input->post('subscription'),
			);
			if ($this->input->post('user_id')) {
				$save = $this->Data_model->updateUser($this->input->post('user_id'), $data);
			} else {
				$save = $this->Data_model->insertUser($data);
				$name = $this->input->post('first_name');
				$verifyLnk = base_url() . "index.php/login/verifyacoountvaimail/" . md5($this->input->post('user_email'));
				$mailtemplete = "<!DOCTYPE html>
				<html>
				<body>
				
				<h1>Welcome to Web Application</h1>
				<p>Hi $name,</p>
				<p> Thank you for register web application. Please verify your account by click below link</p>
				<a href='$verifyLnk'>Click here to verify</a>
				<p>Thanks regards,</p>
				<p>Team </p>
				</body>
				</html>";
				$sendMailObj = array(
					'tomail' => $this->input->post('user_email'),
					'template' => $mailtemplete,
					'subject' => 'Registration! Verify account'
				);
				$mailSend = $this->sendMail($mailtemplete);
			}
			if ($save) {
				redirect('admin', 'refresh');
			} else {
				$this->load->view('admin/header');
				$users = $this->Data_model->getUsers();
				$data = array('user' => $users, 'error' => 'Data Saving Failed');
				$this->load->view('admin/user', $data);
				$this->load->view('admin/footer');
			}
		}
	}
	function sendMail($obj)
	{
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'shalimoljsustin@gmail.com', // change it to yours
			'smtp_pass' => '9995343961', // change it to yours
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
			'wordwrap' => TRUE
		);


		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('samplecodeigniter@gmail.com'); // change it to yours
		$this->email->to($obj['tomail']); // change it to yours
		$this->email->subject($obj['subject']);
		$this->email->message($obj['template']);
		if ($this->email->send()) {
			return 'Email sent.';
		} else {
			return $this->email->print_debugger();
		}
	}
	public function logout()
	{
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('user_type');
		//session_destroy();
		$this->session->sess_destroy();

		redirect('login', 'refresh');
	}
	public function captcha()
	{
		/* $vals = array(
          'img_path' => 'captcha/',
          'img_url' => base_url().'captcha/',
          'img_width'	=> '110',
          'img_height' => 30,
          );
          $captcha = create_captcha($vals); */

		//----------------------- Alternate Captcha Code Start ------------------------
		$vals = array(
			'img_path' => 'captcha/',
			'img_url' => base_url() . 'captcha/',
			'img_width' => '100',
			'font_name' => 'verdanab.ttf',
			'bg_color' => '#3D71C4',
			'char_color' => '#EAECEB',
			'line_count' => '0',
			'img_height' => 30,
		);
		//$this->load->library('newcaptcha');
		$captcha = $this->newcaptcha->get_captcha_image();
		//----------------------- Alternate Captcha Code End ------------------------
		$this->session->set_userdata('captchaWord', $captcha['word']);
		return $captcha;
	}
}
