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
}