<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

	/**
	 * 后台控制器
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
		$this->load->model('BlogsModel','blogs');;
		$taglist = $this->blogs->getAllTags();
		$tag = array();
		foreach($taglist as $k =>$v){
			$tag[$v['id']] = $v;
		}
		$this->load->vars('taglist',$tag);
		$article = $this->blogs->getAdminArticle();
		$this->load->vars('articlelist',$article);
		$this->load->view('blog/index');
	}
	public function edit(){
		$this->load->model('BlogsModel','blogs');
		$taglist = $this->blogs->getAllTags();
		$this->load->vars('taglist',$taglist);
		$id = $this->input->get('id');
		$targetPath =$_SERVER['DOCUMENT_ROOT'] . '/myblog/admin/uploadify/uploads';

		//var_dump($targetPath);exit;
		if($_POST){
			$name = $this->input->post('name');
			$content = $this->input->post('content');
			$status = $this->input->post('status');
			$recommend = $this->input->post('recommend');
			$remark = $this->input->post('remark');
			$showpic = $this->input->post('showpic','');
			$userInfo = $_SESSION['userInfo'];
			$userid = $userInfo->id;//var_dump($userid);
			$data = ['title'=>$name,'status'=>$status,'content'=>$content,'ctime'=>time(),'utime'=>time(),'category'=>$remark,'author_id'=>$userid,'is_recommend'=>$recommend,'show_pic'=>$showpic];
			$res = $this->blogs->upd($id,$data);
			if($res){
				ajaxReturn(['error' => 200, 'msg' => '修改文章成功']);
			}else{
				ajaxReturn(['error' => 100, 'msg' => '修改文章失败']);
			}
		}

		//根据id获取文章内容
		$article = $this->blogs->getArticleContent($id);
		$targetPath = $targetPath.'/'.basename($article['show_pic']);//var_dump($targetPath);exit;
		$this->load->vars('targetPath',$targetPath);
		//var_dump($article);exit(__FILE__.__LINE__);
		$this->load->vars('article',$article);
		$this->load->view('blog/edit');
	}
	public function add(){
		//var_dump($_POST);exit;
		$this->load->model('BlogsModel','blogs');
		$taglist = $this->blogs->getAllTags();
		$this->load->vars('taglist',$taglist);
		if($_POST){
			//获取添加内容
			$name = $this->input->post('name');
			$content = $this->input->post('content');
			$status = $this->input->post('status');
			$recommend = $this->input->post('recommend');
			$remark = $this->input->post('remark');
			$showpic = $this->input->post('showpic','');
			$userInfo = $_SESSION['userInfo'];
			$userid = $userInfo->id;//var_dump($userid);
			$data = ['title'=>$name,'status'=>$status,'content'=>$content,'utime'=>time(),'category'=>$remark,'author_id'=>$userid,'is_recommend'=>$recommend,'show_pic'=>$showpic];
			$res = $this->blogs->add($data);
			if($res){
				ajaxReturn(['error' => 200, 'msg' => '添加文章成功']);
			}else{
				ajaxReturn(['error' => 100, 'msg' => '添加文章失败']);
			}

		}
		$this->load->view('blog/add');
	}
	public function taglist(){
		$this->load->model('BlogsModel','blogs');
		$tags = $this->blogs->getAllTags();
		$this->load->vars('taglist',$tags);
		$this->load->view('blog/taglist');
	}

	/*添加标签*/
	public function addtag(){
		if($_POST){
			//获取添加内容
			$name = $this->input->post('name');
			$status = $this->input->post('status');
			$this->load->model('BlogsModel','blogs');
			$data = ['tagname'=>$name,'status'=>$status,'ctime'=>time(),'utime'=>time()];
			$res = $this->blogs->addtag($data);
			if($res){
				ajaxReturn(['error' => 200, 'msg' => '添加标签成功']);
			}else{
				ajaxReturn(['error' => 100, 'msg' => '添加标签失败']);
			}
		}
		$this->load->view('blog/addtag');
	}
	/*编辑标签*/
	public function edittag(){

		$id = $this->input->get('id');
		$this->load->model('BlogsModel','blogs');
		if($_POST){
			$name = $this->input->post('name');
			$status = $this->input->post('status');
			$data = ['tagname'=>$name,'status'=>$status,'utime'=>time()];
			$res = $this->blogs->updtag($id,$data);
			if($res){
				ajaxReturn(['error' => 200, 'msg' => '修改标签成功']);
			}else{
				ajaxReturn(['error' => 100, 'msg' => '修改标签失败']);
			}
		}
		//根据id获取文章内容
		$tag = $this->blogs->getTag($id);
		//var_dump($article);exit(__FILE__.__LINE__);
		$this->load->vars('tag',$tag);
		$this->load->view('blog/edittag');
	}
	//删除上传图片
	public function deluploadify(){
		$file = $this->input->post('filePath');
		$path = $this->input->post('Path');
		unlink($path);
		echo $file;
		exit;
	}
	//banner图列表
	public function bannerlist(){
		$this->load->model('BlogsModel','blogs');
		$banners = $this->blogs->getBannerList();
		$this->load->vars('banners',$banners);
		$this->load->view('blog/bannerlist');
	}

	//添加banner
	public function addbanner(){
		if($_POST){
			$name = $this->input->post('name');
			$url = $this->input->post('url');
			$desc = $this->input->post('desc');
			$client = $this->input->post('client');
			$sort = $this->input->post('sort');
			$type = $this->input->post('type');
			$data = ['name'=>$name,'url'=>$url,'ctime'=>time(),'desc'=>$desc,'client'=>$client,'sort'=>$sort,'type'=>$type];
			$this->load->model('BlogsModel','blogs');
			$res = $this->blogs->addbaner($data);
			if($res){
				ajaxReturn(['error' => 200, 'msg' => '添加banner成功']);
			}else{
				ajaxReturn(['error' => 100, 'msg' => '添加banner失败']);
			}
		}
		$this->load->view('blog/addbanner');
	}

	/*编辑banner*/
	public function editbanner(){
		$id = $this->input->get('id');
		$this->load->model('BlogsModel','blogs');

		if($_POST){
			$name = $this->input->post('name');
			$url = $this->input->post('url');
			$desc = $this->input->post('desc');
			$client = $this->input->post('client');
			$sort = $this->input->post('sort');
			$type = $this->input->post('type');
			$data = ['name'=>$name,'url'=>$url,'ctime'=>time(),'desc'=>$desc,'client'=>$client,'type'=>$sort,'type'=>$type];
			$res = $this->blogs->updBanner($id,$data);
			if($res){
				ajaxReturn(['error' => 200, 'msg' => '修改标签成功']);
			}else{
				ajaxReturn(['error' => 100, 'msg' => '修改标签失败']);
			}
		}
		//根据id获取文章内容
		$banner = $this->blogs->getBanner($id);
		$targetPath =$_SERVER['DOCUMENT_ROOT'] . '/myblog/admin/uploadify/uploads';
		$targetPath = $targetPath.'/'.basename($banner['url']);//var_dump($targetPath);exit;
		$this->load->vars('targetPath',$targetPath);
		//var_dump($article);exit(__FILE__.__LINE__);
		$this->load->vars('banner',$banner);
		$this->load->view('blog/editbanner');
	}
	/*编辑banner*/
	public function delbanner(){
		$id = $this->input->post('id');
		$this->load->model('BlogsModel','blogs');
		$banner = $this->blogs->getBanner($id);
		if($banner){
			$res = $this->blogs->delBanner($id);
			if($res){
				ajaxReturn(['error' => 200, 'msg' => '删除成功']);
			}else{
				ajaxReturn(['error' => 100, 'msg' => '删除失败']);
			}
		}else{
			ajaxReturn(['error' => 100, 'msg' => 'banner不存在']);
		}
	}
}

