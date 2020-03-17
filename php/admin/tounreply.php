<?php
/**
 * 将提问移至已忽略
 */
require_once 'checklogin.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    return;
}

$list_all = file_get_contents(dirname(dirname(dirname(__FILE__))) . "/question/ask_all.json");
$list_wait = file_get_contents(dirname(dirname(dirname(__FILE__))) . "/question/ask_wait.json");
$list_unreply = file_get_contents(dirname(dirname(dirname(__FILE__))) . "/question/ask_unreply.json");
//$ask_detail = file_get_contents(dirname(dirname(dirname(__FILE__))) . "/question/" . $id . ".json");
if ($list_all == null) {
    $list_all = [];
} else {
    $list_all = json_decode($list_all, true);
}
if ($list_wait == null) {
    $list_wait = [];
} else {
    $list_wait = json_decode($list_wait, true);
}
if ($list_unreply == null) {
    $list_unreply = [];
} else {
    $list_unreply = json_decode($list_unreply, true);
}

$ask_detail = $list_wait[$id];
$ask_detail['reply'] = 2;//状态2:已忽略
//从待回答中移除
unset($list_wait[$id]);
//加入已忽略
$list_unreply[$id] = $ask_detail;
//修改总表状态
$list_all[$id]['reply'] = 2;

//写入各表数据
$file_list_all = fopen(dirname(dirname(dirname(__FILE__))) . "/question/ask_all.json", "w");
fwrite($file_list_all, json_encode($list_all));
fclose($file_list_all);
$file_list_wait = fopen(dirname(dirname(dirname(__FILE__))) . "/question/ask_wait.json", "w");
fwrite($file_list_wait, json_encode($list_wait));
fclose($file_list_wait);
$file_list_unreply = fopen(dirname(dirname(dirname(__FILE__))) . "/question/ask_unreply.json", "w");
fwrite($file_list_unreply, json_encode($list_unreply));
fclose($file_list_unreply);
echo json_encode(array("status"=>0));
