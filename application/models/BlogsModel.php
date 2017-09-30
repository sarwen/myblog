<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/9/29
 * Time: 9:56
 */
class BlogsModel extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    //获取所有标签
    public function getAllTags() {
        $query = $this->db->query("SELECT `id`,`tagname` FROM tags");
        $res = $query->result_array();
        return $res;
    }
    //获取文章列表
    public function getArticle($offset = 0, $limit = 0){
        if($limit){
            $query = $this->db->query("SELECT * FROM article limit $offset,$limit");
        }else{
            $query = $this->db->query("SELECT * FROM article");
        }
        $res = $query->result_array();
        return $res;
    }
    //点击排行
    public function getSort($offset = 0, $limit = 0){
        if($limit){
            $query = $this->db->query("SELECT * FROM article order by click DESC limit $offset,$limit");
        }else{
            $query = $this->db->query("SELECT * FROM article order by click DESC");
        }
        $res = $query->result_array();
        return $res;
    }
    //最新文章
    public function getNew($offset = 0, $limit = 0){
        if($limit){
            $query = $this->db->query("SELECT * FROM article order by ctime desc limit $offset,$limit");
        }else{
            $query = $this->db->query("SELECT * FROM article order by click DESC");
        }
        $res = $query->result_array();
        return $res;
    }
    //站长推荐
    public function getRecommend($offset = 0, $limit = 0){
        if($limit){
            $query = $this->db->query("SELECT * FROM article order by click DESC limit $offset,$limit");
        }else{
            $query = $this->db->query("SELECT * FROM article order by click DESC");
        }
        $res = $query->result_array();
        return $res;
    }
    //文章内容
    public function getArticleContent($id){
        $query = $this->db->query("SELECT * FROM article WHERE id=$id");
        $res = $query->row_array();
        return $res;
    }


}