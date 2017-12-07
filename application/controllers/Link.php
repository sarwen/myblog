<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Link extends CI_Controller {

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
		$this->load->model('LinkModel','link');
		$list = $this->link->getAllLink();
		$this->load->vars('list',$list);
		$this->load->view('blog/linklist');
	}

	//添加友链
	public function add(){
		if($_POST){
			$name = $this->input->post('name');
			$url = $this->input->post('link');
			$status = $this->input->post('status');
			$data = ['link_name'=>$name,'link'=>$url,'ctime'=>time(),'utime'=>time(),'status'=>$status];
			$this->load->model('LinkModel','link');
			$res = $this->link->addLink($data);
			if($res){
				ajaxReturn(['error' => 200, 'msg' => '添加友链成功']);
			}else{
				ajaxReturn(['error' => 100, 'msg' => '添加友链失败']);
			}
		}
		$this->load->view('blog/addlink');
	}

	/*编辑友链*/
	public function edit(){
		$id = $this->input->get('id');
		$this->load->model('LinkModel','link');

		if($_POST){
			$name = $this->input->post('name');
			$url = $this->input->post('link');
			$status = $this->input->post('status');
			$data = ['link_name'=>$name,'link'=>$url,'utime'=>time(),'status'=>$status];
			$res = $this->link->updLink($id,$data);
			if($res){
				ajaxReturn(['error' => 200, 'msg' => '修改友链成功']);
			}else{
				ajaxReturn(['error' => 100, 'msg' => '修改友链失败']);
			}
		}
		//根据id获取友链
		$link = $this->link->getLink($id);
		$this->load->vars('link',$link);
		$this->load->view('blog/editlink');
	}
	/*删除友链r*/
	public function delete(){
		$id = $this->input->post('id');
		$this->load->model('LinkModel','link');
		$link = $this->link->getLink($id);
		if($link){
			$res = $this->link->delLink($id);
			if($res){
				ajaxReturn(['error' => 200, 'msg' => '删除成功']);
			}else{
				ajaxReturn(['error' => 100, 'msg' => '删除失败']);
			}
		}else{
			ajaxReturn(['error' => 100, 'msg' => '该友链不存在']);
		}
	}
}

