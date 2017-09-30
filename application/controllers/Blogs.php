<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs extends CI_Controller {

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
		//$this->load->library('session');
		$this->load->helper(array('base','url'));
	/*	if(!checklogin()){
			$this->login();
		}*/
		$this->load->model('BlogsModel','blogs');
		//标签栏
		$tagsInfo = $this->blogs->getAllTags();///var_dump($tagsInfo);exit(__FILE__.__LINE__);
		if($tagsInfo){
			foreach($tagsInfo as &$k){
				$k['url'] = site_url().'/Blogs/tag/'.$k['id'];
			}
		}
		$this->load->vars('taglist',$tagsInfo);
		//点击排行
		$sortArticle = $this->blogs->getSort();
		$this->load->vars('sortArticle',$sortArticle);

		//最新文章
		$newArticle = $this->blogs->getNew();
		$this->load->vars('newArticle',$newArticle);

		//站长推荐
		$recommendArticle = $this->blogs->getRecommend();
		$this->load->vars('recommendArticle',$recommendArticle);
	}

	public function index() {
		//文章栏
		$article = $this->blogs->getArticle();
		$this->load->vars('articlelist',$article);

		$this->load->view('blog_index/index');
	}
	public function content(){
		$id = $this->input->get('id');
		//根据id获取文章内容
		$article = $this->blogs->getArticleContent($id);
		$this->load->vars('article',$article);
		$this->load->view('blog_index/content');
	}
}

