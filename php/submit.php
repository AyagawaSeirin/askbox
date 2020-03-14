<?php
require_once '../lib/geetest/verify.php';

$check = new geetestcheck;
if(!$check::check()){
    echo json_encode(array("status"=>1,"msg"=>"验证码验证失败!"));
    return;
}
//echo json_encode(array("status"=>0));

