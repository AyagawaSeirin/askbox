<?php
require_once dirname(dirname(__FILE__)) . '/geetest/lib/class.geetestlib.php';
require_once dirname(dirname(dirname(__FILE__))) . "/config.php";

class geetestcheck
{

    public static function check()
    {
        session_start();
//        print_r($_SESSION);
//        session_write_close();
        $GtSdk = new GeetestLib(__GEETEST_CAPTCHA_ID__, __GEETEST_PRIVATE_KEY__);
        $data = array(
//    "user_id" => $_SESSION['user_id'], # 网站用户id
            "user_id" => "askbox",
            "client_type" => "web",
            "ip_address" => $_SERVER['REMOTE_ADDR']
        );
        if ($_SESSION['gtserver'] === 0) {//服务器宕机,走failback模式
            echo 123;
            if ($GtSdk->fail_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'])) {
                return true;
            } else {
                return false;
            }
        } else {//服务器正常
            $result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $data);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }
}