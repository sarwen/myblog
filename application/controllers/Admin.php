<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper(array('base','url'));
		if(!checklogin()){
			$this->login();
		}
	}

	public function index() {
		$userInfo = $_SESSION['userInfo'];
		$this->load->vars('userInfo',(array)$userInfo);
		$this->load->view('admin_index');
	}
	public function login(){
		if($_POST){
			if(checkLogin()){
				redirect('admin/index');
			}

			$name = $this->input->post('username',true);
			$this->load->model('AdminModel','userModel');
			$userInfo = $this->userModel->getUserInfoByName($name);
			if(empty($userInfo)){
				echo '用户或者密码错误';
				$this->load->view('admin_login');
			}
			$pwd = $this->input->post('password',true);
			if($userInfo->password == md5($pwd)){
				//验证成功
				$_SESSION['userInfo'] = $userInfo;
				redirect('admin/index');
			}else{
				echo '用户或者密码错误';
				$this->load->view('admin_login');
			}
		}else{
			$this->load->view('admin_login');
		}
	}
	public function loginout(){
		$this->session->unset_userdata('userInfo');
		redirect('admin/login');
	}
}

