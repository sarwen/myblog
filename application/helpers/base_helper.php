<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! function_exists('checkLogin'))
{
    function checkLogin(){
        return isset($_SESSION['userInfo'])? true : false;
    }
}
/**
 * 递归重组节点信息
 */
function node_merges($node, $access = array(), $pid = 0, $id = 'id')
{
    $arr = array();
    foreach ($node as $k => $nodeList) {
        if (is_array($node)) {
            $nodeList['access'] = in_array($nodeList[$id], $access) ? 1 : 0;
        }
        if ($nodeList['parent_id'] == $pid) {
            $nodeList['child'] = node_merges($node, $access, $nodeList[$id]);
            if (empty($nodeList['child'])) {
                $nodeList['show'] = 0;
            } else {
                $nodeList['show'] = 1;
            }
            $arr[] = $nodeList;
        }
    }
    return $arr;
}
function ajaxReturn($data)
{
    echo json_encode($data);
    exit;
}
function httpget($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
    // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    /*curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);*/
    curl_setopt($curl, CURLOPT_URL, $url);
    $res = curl_exec($curl);
    curl_close($curl);
    return $res;
}