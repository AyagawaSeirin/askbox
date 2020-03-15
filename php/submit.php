<?php
require_once dirname(dirname(__FILE__)).'/lib/geetest/verify.php';
require_once dirname(dirname(__FILE__)).'/lib/mail/email.php';
require_once dirname(dirname(__FILE__)).'/config.php';

$check = new geetestcheck;
if(!$check::check()){
    echo json_encode(array("status"=>1,"msg"=>"验证码验证失败!"));
    return;
}

$content = $_POST['text'];
$email = $_POST['email'];

$content = "测试提问内容数据";
$email = "AyagawaSeirin@qq.com";

if($content == null){
    echo json_encode(array("status"=>1,"msg"=>"请输入提问内容~"));
    return;
}


$time = time();

//写入总提问数据文件
$ask_all = file_get_contents("../question/ask_all.json");
if ($ask_all == null) {
    $new_id = 10001;
    $ask_all = [];
} else {
    $ask_all = json_decode($ask_all,true);
    $new_id = end($ask_all)['id'] + 1;
}
$this_info = array(
    "id" => $new_id,
    "creat_time" => $time,
//    "reply_time" => "",
    "reply" => 0,
);
//array_push($ask_all, $this_info);
$ask_all[$new_id]=$this_info;
$file_ask_all = fopen("../question/ask_all.json", "w");
fwrite($file_ask_all, json_encode($ask_all));
fclose($file_ask_all);

//写入待回答提问数据文件
$ask_wait = file_get_contents("../question/ask_wait.json");
if ($ask_wait == null) {
    $ask_wait = [];
} else {
    $ask_wait = json_decode($ask_wait,true);
}
$ask_wait[$new_id]=$this_info;
$file_ask_wait = fopen("../question/ask_wait.json", "w");
fwrite($file_ask_wait, json_encode($ask_wait));
fclose($file_ask_wait);

//写入提问数据文件
$this_info['content'] = $content;
$this_info['email'] = $email;
$this_info['reply'] = "";
$file_ask = fopen("../question/".$new_id.".json", "w");
fwrite($file_ask, json_encode($this_info));
fclose($file_ask);

//发送邮件提醒到管理员
//读取模版文件
$site_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
$theme = file_get_contents("../theme/newask.html");
$theme = str_replace("{askboxUrl}",$site_url,$theme);
$theme = str_replace("{content}",$content,$theme);
$theme = str_replace("{time}",date("Y-m-d H:i:s",$time),$theme);
$theme = str_replace("{replyUrl}",$site_url."/",$theme);
//发送邮件
$sendmail = new sendemail;
$sendmail->sendemail(__BASIC_EMAIL__, '匿名提问箱有新提问啦', $theme);

echo json_encode(array("status"=>0,"id"=>$new_id));