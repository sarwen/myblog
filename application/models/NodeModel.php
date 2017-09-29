<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/9/29
 * Time: 9:56
 */
class NodeModel extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    //获取所有节点
    public function getAllNode() {
        $query = $this->db->query("SELECT * FROM node");
        $res = $query->result_array();
        return $res;
    }
}