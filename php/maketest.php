<?php

$content = "测试提问内容数据";
$email = "AyagawaSeirin@qq.com";


$time = time();

//写入总提问数据文件
$ask_all = file_get_contents("../question/ask_all.json");
if ($ask_all == null) {
    $new_id = 10001;
    $ask_all = [];
} else {
    $ask_all = json_decode($ask_all,true);
    $key = array_keys($ask_all);
    $new_id = end($key) + 1;
}
$this_info = array(
//    "id" => $new_id,
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
$this_info['status'] = 0;
$file_ask = fopen("../question/".$new_id.".json", "w");
fwrite($file_ask, json_encode($this_info));
fclose($file_ask);

echo json_encode(array("status"=>0,"id"=>$new_id));