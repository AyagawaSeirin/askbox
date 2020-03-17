<?php
/**
 * 彻底删除提问
 */

require_once 'checklogin.php';

if (isset($_GET['id']) == true && isset($_GET['by']) == true) {
    $id = $_GET['id'];
    $by = $_GET['by'];
} else {
    return;
}

if ($by == 1) {
    $by = "wait";
} elseif ($by == 2) {
    $by = "unreply";
}

$list_all = file_get_contents(dirname(dirname(dirname(__FILE__))) . "/question/ask_all.json");
$list_by = file_get_contents(dirname(dirname(dirname(__FILE__))) . "/question/ask_" . $by . ".json");

if ($list_all == null) {
    $list_all = [];
} else {
    $list_all = json_decode($list_all, true);
}
if ($list_by == null) {
    $list_by = [];
} else {
    $list_by = json_decode($list_by, true);
}

//删除数据
unset($list_all[$id]);
unset($list_by[$id]);

//删除文件
unlink(dirname(dirname(dirname(__FILE__))) . "/question/" . $id . ".json");

//写入各表数据
$file_list_all = fopen(dirname(dirname(dirname(__FILE__))) . "/question/ask_all.json", "w");
fwrite($file_list_all, json_encode($list_all));
fclose($file_list_all);
$file_list_by = fopen(dirname(dirname(dirname(__FILE__))) . "/question/ask_" . $by . ".json", "w");
fwrite($file_list_by, json_encode($list_by));
fclose($file_list_by);
echo json_encode(array("status" => 0));
