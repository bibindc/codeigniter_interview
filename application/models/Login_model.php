<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function auth_user()
    {        
        $user=$this->input->post('login_email');
        $pass=$this->input->post('login_pass');
        $qry="select * from users where US_Email='$user' and US_Password=md5('$pass') and US_Status=2";
        $query =$this->db->query($qry);
        return $query->result();
    }
    public function auth_user_mail($hash){
        $user=$this->input->post('login_email');
        $pass=$this->input->post('login_pass');
        $qry="select * from users where MD5(US_Email)='$hash' ";
        $query =$this->db->query($qry);        
        return $query->result();
    }
}
