<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Data_model');
		$this->load->helper(array(
			'form',
			'url'
		));
		$this->load->library('pagination');
	}

	public function index($id=0)
	{
		$this->load->view('customer/header', ['objSession' => $this->session]);
		$subscribed = $this->session->userdata('user_subscribe');

		if ($this->uri->segment(3)) {
			$page = $this->uri->segment(3);
		} else {
			$page = "";
		}
		if ($page) {
			if (!is_numeric($page)) {
				redirect('login');
			}
		}
		$config = array();
        $config["base_url"] = base_url() . "index.php/customer/index";
        $total_row = $this->Data_model->getStoriesCount($subscribed);
        $config["total_rows"] = $total_row;
        $config["per_page"] = 2;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = $total_row;
        $config['cur_tag_open'] = '&nbsp;<a class="current">';
        $config['cur_tag_close'] = '</a>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $config['uri_segment'] = 3;

        $this->pagination->initialize($config);
        $page = $page ? $page : 1;
        $offset = ($page - 1) * $config["per_page"];
        $query = $this->Data_model->getStories($config["per_page"], $offset, $subscribed);
        $data['stories'] = $query;
        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;', $str_links);

		//$stories = $this->Data_model->getStories($subscribed);
		$this->load->view('customer/customer', $data);
		$this->load->view('customer/footer');
	}
	public function viewdata($id)
	{
		$this->load->view('customer/header', ['objSession' => $this->session]);
		$stories = $this->Data_model->getStoriesDetails($id);
		$this->load->view('customer/storydetails', ['stories' => $stories]);
		$this->load->view('customer/footer');
	}
}
