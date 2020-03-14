<?php
require_once dirname(dirname(__FILE__)) . '/geetest/lib/class.geetestlib.php';
require_once "../../config.php";

class geetestcheck
{

    public static function check()
    {

        session_start();
        $GtSdk = new GeetestLib($config['geetest']['CAPTCHA_ID'], $config['geetest']['PRIVATE_KEY']);
        $data = array(
//    "user_id" => $_SESSION['user_id'], # 网站用户id
            "user_id" => "askbox",
            "client_type" => "web",
            "ip_address" => $_SERVER['REMOTE_ADDR']
        );
        if ($_SESSION['gtserver'] == 1) {   //服务器正常
            $result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $data);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {  //服务器宕机,走failback模式
            if ($GtSdk->fail_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'])) {
                return true;
            } else {
                return false;
            }
        }
    }

}