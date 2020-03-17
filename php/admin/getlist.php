<?php
require_once 'checklogin.php';

$type = $_GET['type'];
$page = $_GET['page'];
$amount = $_GET['amount'];

if ($type == null) $type = "wait";
if ($page == null) $page = 1;
if ($amount == null) $amount = 5;


$list = file_get_contents(dirname(dirname(dirname(__FILE__))) . "/question/ask_" . $type . ".json");
if ($list == null) {
    $list = [];
} else {
    $list = json_decode($list, true);
}
$key = array_keys($list);
$start = ($page - 1) * $amount;
$end = $page * $amount - 1;
$page_amount = ceil(count($key)/$amount);
$data = [];
for ($t = 0; $t < $amount; $t++) {
    $key_now = $start + $t;
    if (!isset($key[$key_now])) {
        break;
    }
    if($t == 0){
        $data[$t]['pageamount'] = $page_amount;
    }

    $id = $key[$key_now];
    $content = json_decode(file_get_contents(dirname(dirname(dirname(__FILE__))) . "/question/" . $id . ".json"),true);
    $content = $content['content'];

    $data[$t]['id'] = $id;
    $data[$t]['time'] = date("Y-m-d H:i:s",$list[$id]['creat_time']);
    $data[$t]['content'] = $content;
}
//$data['pageamount'] = $page_amount;
echo json_encode($data);