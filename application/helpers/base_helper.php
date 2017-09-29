<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! function_exists('site_url'))
{
    function checkLogin(){
        return isset($_SESSION['userInfo'])? true : false;
    }
}