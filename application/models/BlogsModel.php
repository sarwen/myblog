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
        $query = $this->db->query("SELECT * FROM tags");
        $res = $query->result_array();
        return $res;
    }
    //获取文章列表
    public function getArticle($offset = 0, $limit = 0){
        if($limit){
            $query = $this->db->query("SELECT * FROM article where status=1 limit $offset,$limit");
        }else{
            $query = $this->db->query("SELECT * FROM article where status=1");
        }
        $res = $query->result_array();
        return $res;
    }
    //获取文章列表
    public function getAdminArticle($offset = 0, $limit = 0){
        if($limit){
            $query = $this->db->query("SELECT * FROM article where  limit $offset,$limit");
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
    public function add($data){
       //var_dump($data);exit(__FILE__.__LINE__);
        //var_dump($this->db);
        $res = $this->db->insert('article', $data);

        //var_dump($res);exit(__FILE__.__LINE__);
        return $res;
    }
    public function upd($id, $data){
        //var_dump($data);exit(__FILE__.__LINE__);
        //var_dump($this->db);
        $where = "id=$id";
        $this->db->where('id', $id);
        $res = $this->db->update('article', $data);
       /* $res = $this->db->update_string('article', $data, $where);*/
        //var_dump($res);exit(__FILE__.__LINE__);
        return $res;
    }
}