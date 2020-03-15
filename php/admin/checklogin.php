<?php
/**
 * 检查管理员登录状态是否正常
 */
if (!isset($_COOKIE['askbox_admin'])) {
    //滚去登录
    header('location: /admin/login.php');
} else {

    $id = $_COOKIE['askbox_admin'];
    $log_all = json_decode(file_get_contents(dirname(dirname(dirname(__FILE__))) . "/admin/log/login.log"), true);

    if (!isset($log_all[$id])) {
        //不存在的登录id，删除COOKIE并滚去登录!
        setcookie("askbox_admin", "", time() - 10800, "/", $_SERVER['HTTP_HOST']);
        header('location: /admin/login.php');
    }

    if ($log_all[$id]['IP'] != getip()) {
        //登录id并不属于这个IP，可能切换了网络环境，不过还是滚去登录吧
        setcookie("askbox_admin", "", time() - 10800, "/", $_SERVER['HTTP_HOST']);
        header('location: /admin/login.php');
    }

    if(time() - $log_all[$id]['time'] > 10800){
        //超时了，滚去登录吧
        setcookie("askbox_admin", "", time() - 10800, "/", $_SERVER['HTTP_HOST']);
        header('location: /admin/login.php');
    }

}


function getip()
{
    static $ip = '';
    $ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_CDN_SRC_IP'])) {
        $ip = $_SERVER['HTTP_CDN_SRC_IP'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
        foreach ($matches[0] AS $xip) {
            if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                $ip = $xip;
                break;
            }
        }
    }
    return $ip;
}