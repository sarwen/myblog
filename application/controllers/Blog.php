<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

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
			redirect('Admin/login');
		}
		$userInfo = $_SESSION['userInfo'];
		$this->load->vars('userInfo',(array)$userInfo);
		$this->load->model('NodeModel','nodeModel');
		$nodelist = $this->nodeModel->getAllNode();
		$nodelist = node_merges($nodelist);
		$this->load->vars('nodelist',$nodelist);
	}

	public function lists() {
//		$userInfo = $_SESSION['userInfo'];
//		$this->load->vars('userInfo',(array)$userInfo);
		$this->load->model('BlogsModel','blogs');
		$article = $this->blogs->getArticle();
		$this->load->vars('articlelist',$article);
		$this->load->view('blog/index');
	}
	public function edit(){

		$id = $this->input->get('id');
		$this->load->model('BlogsModel','blogs');
		//根据id获取文章内容
		$article = $this->blogs->getArticleContent($id);
		$this->load->vars('article',$article);
		$this->load->view('blog/edit');
	}
	public function add(){
		//var_dump($_POST);exit;
		if($_POST){
			//获取添加内容
			$name = $this->input->post('name');
			$content = $this->input->post('content');
			$status = $this->input->post('status');
			$remark = $this->input->post('remark');
			$cat = $this->input->post('category');
			$userInfo = $_SESSION['userInfo'];
			$userid = $userInfo->id;//var_dump($userid);
			$this->load->model('BlogsModel','blogs');
			$data = ['title'=>$name,'status'=>$status,'remark'=>$remark,'content'=>$content,'ctime'=>time(),'ctime'=>time(),'category'=>$cat,'author_id'=>$userid];
			$res = $this->blogs->add($data);
			if($res){
				ajaxReturn(['error' => 200, 'msg' => '添加文章成功']);
			}else{
				ajaxReturn(['error' => 100, 'msg' => '添加文章失败']);
			}

		}
		$this->load->view('blog/add');
	}
}

