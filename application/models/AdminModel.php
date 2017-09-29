<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/9/29
 * Time: 9:56
 */
class AdminModel extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    //登录
    public function getUserInfoByName($name) {
        if(empty($name)){
            return false;
        }
        $this->load->database();
        $query = $this->db->query("SELECT `name`,`password` FROM admin_user where `name`='".$name."'");
        $res = $query->row();
        return $res;
    }
    //注销
    public  function loginout() {

    }
}