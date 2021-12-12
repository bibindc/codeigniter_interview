<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Data_model');
		$this->load->library('form_validation');
		$this->load->helper(array(
			'form',
			'url'
		));
	}

	public function index()
	{
		$this->load->view('admin/header', ['objSession' => $this->session]);
		$users = $this->Data_model->getUsers();
		$data = array('user' => $users);
		$this->load->view('admin/user', $data);
		$this->load->view('admin/footer');
	}
	public function adduser()
	{
		$this->load->view('admin/header', ['objSession' => $this->session]);
		$countries = $this->Data_model->getCountries();
		$data = array('countries' => $countries);
		$this->load->view('admin/adduser', $data);
		$this->load->view('admin/footer');
	}
	public function edituser($id = 0)
	{
		$this->load->view('admin/header', ['objSession' => $this->session]);
		$countries = $this->Data_model->getCountries();
		$users = $this->Data_model->getUserData($id);
		$data = array('user' => $users, 'countries' => $countries);
		$this->load->view('admin/edituser', $data);
		$this->load->view('admin/footer');
	}
	public function deleteuser($id)
	{
		if ($id) {
			$users = $this->Data_model->deleteUser($id);
		}
		redirect('admin', 'refresh');
	}
	public function do_user_insert()
	{
		$config = array(
			array(
				'field' => 'fname',
				'label' => 'First name',
				'rules' => 'required'
			),
			array(
				'field' => 'lname',
				'label' => 'Last name',
				'rules' => 'required'
			),
			array(
				'field' => 'email',
				'label' => ' Email',
				'rules' => 'required|valid_email'
			),
			array(
				'field' => 'pwd',
				'label' => 'Password',
				'rules' => 'required'
			),
			array(
				'field' => 'country',
				'label' => 'Country',
				'rules' => 'required'
			),
			array(
				'field' => 'subscribe',
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
			$this->adduser();
		} else {
			$data = array(
				"US_FirstName" => $this->input->post('fname'),
				"US_LastName" => $this->input->post('lname'),
				"US_Dob" => date('Y-m-d', strtotime($this->input->post('dob'))),
				"US_Email" => $this->input->post('email'),
				"US_Password" => md5("'" . $this->input->post('pwd') . "'"),
				"US_Type" => 2,
				"US_Status" => 1,
				"US_Country" => $this->input->post('country'),
				"US_Phone" => $this->input->post('phone'),
				"US_Subscription" => $this->input->post('subscribe'),
			);

			$save = $this->Data_model->insertUser($data);
			$name = $this->input->post('fname');
			$verifyLnk = base_url() . "index.php/login/verifyacoountvaimail/" . md5($this->input->post('email'));
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
				'tomail' => $this->input->post('email'),
				'template' => $mailtemplete,
				'subject' => 'Registration! Verify account'
			);
			$mailSend = $this->sendMail($mailtemplete);
			if ($save) {
				redirect('admin', 'refresh');
			} else {
				$this->load->view('admin/header', ['objSession' => $this->session]);
				$users = $this->Data_model->getUsers();
				$data = array('user' => $users, 'error' => 'Data Inserting Failed');
				$this->load->view('admin/adduser', $data);
				$this->load->view('admin/footer');
			}
		}
	}
	public function do_user_update()
	{
		$config = array(
			array(
				'field' => 'fname',
				'label' => 'First name',
				'rules' => 'required'
			),
			array(
				'field' => 'lname',
				'label' => 'Last name',
				'rules' => 'required'
			),
			array(
				'field' => 'email',
				'label' => ' Email',
				'rules' => 'required|valid_email'
			),
			array(
				'field' => 'country',
				'label' => 'Country',
				'rules' => 'required'
			),
			array(
				'field' => 'subscribe',
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
			$this->edituser($this->input->post('user_id'));
		} else {
			$data = array(
				"US_FirstName" => $this->input->post('fname'),
				"US_LastName" => $this->input->post('lname'),
				"US_Dob" => date('Y-m-d', strtotime($this->input->post('dob'))),
				"US_Email" => $this->input->post('email'),
				//"US_Password" => md5("'" . $this->input->post('pwd') . "'"),
				//"US_Type" => 2,
				//"US_Status" => 1,
				"US_Country" => $this->input->post('country'),
				"US_Phone" => $this->input->post('phone'),
				"US_Subscription" => $this->input->post('subscribe'),
			);
			if ($this->input->post('user_id')) {
				$save = $this->Data_model->updateUser($this->input->post('user_id'), $data);
			}
			if ($save) {
				redirect('admin', 'refresh');
			} else {
				$this->load->view('admin/header', ['objSession' => $this->session]);
				$users = $this->Data_model->getUserData($this->input->post('user_id'));
				$data = array('user' => $users, 'error' => 'Data Saving Failed');
				$this->load->view('admin/edituser', $data);
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
}
