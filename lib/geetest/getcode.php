<?php
require_once dirname(dirname(__FILE__)) . '/geetest/lib/class.geetestlib.php';
require_once "../../config.php";

session_start();
$GtSdk = new GeetestLib($config['geetest']['CAPTCHA_ID'], $config['geetest']['PRIVATE_KEY']);
$data = array(
    "user_id" => "askbox",
    "client_type" => "web",
    "ip_address" => $_SERVER['REMOTE_ADDR'],
);

$status = $GtSdk->pre_process($data, 1);
$_session['gtserver'] = $status;
$_session['user_id'] = $data['user_id'];
echo $GtSdk->get_response_str();