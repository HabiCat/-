<?php
/**
 * Created by PhpStorm.
 * User: 111job
 * Date: 14-8-2
 * Time: 下午1:48
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('XUtils');
    }

    public function login() {
        if($this->xutils->method() == 'POST') {
            $data = $this->input->post('Admin');
            $password = md5($data['password']);
            $query = $this->db->query('select id,username from t_pq_admin where username = "' . $data['username'] . '" AND password = "' . $password . '"');
            $result = $query->row_array();
			
            if(!empty($result)) {
                $this->session->set_userdata('adminid', $result['id']);
                $this->session->set_userdata('username', $result['username']);
                $this->xutils->message("success", '登陆成功', site_url('admin/index'));
            }
        }

        $this->load->view('admin/login');
    }

    public function logout() {
        $this->session->unset_userdata('adminid');
        $this->session->unset_userdata('username');

        $this->xutils->message('success', '退出成功', site_url('common/login'));
    }
}