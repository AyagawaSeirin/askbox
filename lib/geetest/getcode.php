<?php
require_once dirname(dirname(__FILE__)) . '/geetest/lib/class.geetestlib.php';
require_once dirname(dirname(dirname(__FILE__)))."/config.php" ;

session_start();
$GtSdk = new GeetestLib(__GEETEST_CAPTCHA_ID__, __GEETEST_PRIVATE_KEY__);
$data = array(
    "user_id" => "askbox",
    "client_type" => "web",
    "ip_address" => $_SERVER['REMOTE_ADDR'],
);
$status = $GtSdk->pre_process($data, 1);
$_session['gtserver'] = $status;
$_session['user_id'] = $data['user_id'];
session_write_close();
echo $GtSdk->get_response_str();