<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/9/29
 * Time: 9:56
 */
class LinkModel extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    //获取所有节点
    public function getAllLink() {
        $query = $this->db->query("SELECT * FROM link");
        $res = $query->result_array();
        return $res;
    }
    public function addLink($data){
        $res = $this->db->insert('link', $data);
        return $res;
    }
    public function updLink($id,$data){
        $this->db->where('id', $id);
        $res = $this->db->update('link', $data);
        return $res;
    }
    public function delLink($id){
        $this->db->where('id', $id);
        $res = $this->db->delete('link');
        return $res;
    }
    public function getLink($id){
        $query = $this->db->query("SELECT * FROM link WHERE id=$id");
        $res = $query->row_array();
        return $res;
    }
    public function getIndexLink(){
        $query = $this->db->query("SELECT * FROM link where status=1");
        $res = $query->result_array();
        return $res;
    }
}