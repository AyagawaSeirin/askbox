<?php
/**
 * 将提问移至待回答
 */

require_once 'checklogin.php';

if (isset($_GET['id']) == true && isset($_GET['by']) == true) {
    $id = $_GET['id'];
    $by = $_GET['by'];
} else {
    return;
}

if($by == 1){
    $by = "reply";
} elseif($by == 2){
    $by = "unreply";
}

$list_all = file_get_contents(dirname(dirname(dirname(__FILE__))) . "/question/ask_all.json");
$list_wait = file_get_contents(dirname(dirname(dirname(__FILE__))) . "/question/ask_wait.json");
$list_by = file_get_contents(dirname(dirname(dirname(__FILE__))) . "/question/ask_".$by.".json");

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
if ($list_by == null) {
    $list_by = [];
} else {
    $list_by = json_decode($list_by, true);
}


$ask_detail = $list_by[$id];
$ask_detail['reply'] = 0;//状态0:待回答
//从原数据文件中移除
unset($list_by[$id]);
//加入待回答
$list_wait[$id] = $ask_detail;
//修改总表状态
$list_all[$id]['reply'] = 0;

//写入各表数据
$file_list_all = fopen(dirname(dirname(dirname(__FILE__))) . "/question/ask_all.json", "w");
fwrite($file_list_all, json_encode($list_all));
fclose($file_list_all);
$file_list_wait = fopen(dirname(dirname(dirname(__FILE__))) . "/question/ask_wait.json", "w");
fwrite($file_list_wait, json_encode($list_wait));
fclose($file_list_wait);
$file_list_by = fopen(dirname(dirname(dirname(__FILE__))) . "/question/ask_".$by.".json", "w");
fwrite($file_list_by, json_encode($list_by));
fclose($file_list_by);
echo json_encode(array("status"=>0));