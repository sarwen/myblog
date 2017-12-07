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
				$k['url'] = site_url().'/Blogs/tagarticle?id='.$k['id'];
			}
		}
		$this->load->vars('taglist',$tagsInfo);
		//点击排行
		$sortArticle = $this->blogs->getSort(0,6);
		$this->load->vars('sortArticle',$sortArticle);

		//最新文章
		$newArticle = $this->blogs->getNew(0,6);
		$this->load->vars('newArticle',$newArticle);

		//站长推荐
		$recommendArticle = $this->blogs->getRecommend(0,6);
		$this->load->vars('recommendArticle',$recommendArticle);
		//banner图
		$banners = $this->blogs->getBannerList(1);
		$this->load->vars('banners',$banners);
		//右上侧广告图
		$add1 = $this->blogs->getBannerList(2);
		$this->load->vars('add1',$add1);
		//右下侧广告图
		$add2 = $this->blogs->getBannerList(3);
		$this->load->vars('add2',$add2);
		//友情链接
		$this->load->model('LinkModel','link');
		$where = array('status'=>1);
		$links = $this->link->getIndexLink();
		$this->load->vars('links',$links);
		$func = $this->router->fetch_method();
		$this->load->vars('func',$func);
	}

	/*首页*/
	public function index() {
		//文章栏
		$article = $this->blogs->getArticle();
		$ids = array_column($article,'id');
		$ids = implode(',',$ids);
		//获取畅言的评论数
		$url = "http://changyan.sohu.com/api/2/topic/count?client_id=cyths4ICA&topic_source_id={$ids}";
		$res = httpget($url);
		$res = json_decode($res,true);
		foreach($article as $k =>$v){
			foreach($res['result'] as $key =>$val){
				if($key == $v['id']){
					$article[$k]['comments'] = $val['comments'];
				}
			}
		}
		//var_dump($res);exit;
		$this->load->vars('articlelist',$article);
		$this->load->view('blog_index/index');
	}
	/*标签文章列表*/
	public function tagarticle() {
		//文章栏
		$id = $this->input->get('id');
		$tagname = $this->blogs->getTagname($id);
		$this->load->vars('tagname',$tagname);

		//获取分类文章列表
		$article = $this->blogs->getArticlesByTag($id);
		$ids = array_column($article,'id');
		$ids = implode(',',$ids);
		//获取畅言的评论数
		$url = "http://changyan.sohu.com/api/2/topic/count?client_id=cyths4ICA&topic_source_id={$ids}";
		$res = httpget($url);
		$res = json_decode($res,true);
		foreach($article as $k =>$v){
			foreach($res['result'] as $key =>$val){
				if($key == $v['id']){
					$article[$k]['comments'] = $val['comments'];
				}
			}
		}
		$this->load->vars('articlelist',$article);
		$this->load->view('blog_index/tagarticle');
	}
	/*文章内容页*/
	public function content(){
		$id = $this->input->get('id');
		//根据id获取文章内容
		$article = $this->blogs->getArticleContent($id);
		//更新浏览量
		$res = $this->blogs->addScan($id);
		if(!$res){
			logs("更新浏览量失败，文章id为：$id",'scanContent');
		}
		$this->load->vars('article',$article);
		$this->load->view('blog_index/content');
	}
	//关于我
	public function about(){
		$article = $this->blogs->getArticleContent(1);
		$this->load->vars('article',$article);
		$this->load->view('blog_index/content');
	}
}

