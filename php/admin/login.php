<?php
require_once dirname(dirname(dirname(__FILE__))) . '/lib/geetest/verify.php';
require_once dirname(dirname(dirname(__FILE__))) . '/config.php';

$check = new geetestcheck;
if (!$check::check()) {
    echo json_encode(array("status" => 1, "msg" => "验证码验证失败!"));
    return;
}

$pw = $_POST['password'];

if($pw == null){
    echo json_encode(array("status" => 1, "msg" => "没填写密码呀!"));
    return;
}

if ($pw == __BASIC_PASSWORD__) {
    //登录成功

    //记入登录数据
    $log_all = file_get_contents(dirname(dirname(dirname(__FILE__)))."/admin/log/login.log");
    if ($log_all == null) {
        $log_all = [];
    } else {
        $log_all = json_decode($log_all, true);
    }
    $id = rand(10000000, 99999999);
    $log_all[$id]['id'] = $id;
    $log_all[$id]['IP'] = getip();
    $log_all[$id]['time'] = time();
    $file_log = fopen(dirname(dirname(dirname(__FILE__)))."/admin/log/login.log", "w");
    fwrite($file_log, json_encode($log_all));
    fclose($file_log);

    //设置登录状态
    setcookie("askbox_admin", $id, time()+10800, "/", $_SERVER['HTTP_HOST']);
    echo json_encode(array("status" => 0,));
    return;
} else {
    echo json_encode(array("status" => 1, "msg" => "密码错误!"));
    return;
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