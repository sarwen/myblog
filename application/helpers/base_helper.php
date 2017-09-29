<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! function_exists('site_url'))
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