<?php
require_once 'checklogin.php';

$text = $_POST['text'];
$id = $_GET['id'];
$mode = $_GET['mode'];

$content = json_decode(file_get_contents(dirname(dirname(dirname(__FILE__))) . "/question/" . $id . ".json"),true);

$content['reply'] = $text;

$list_all = file_get_contents(dirname(dirname(dirname(__FILE__))) . "/question/ask_all.json");
$list_reply = file_get_contents(dirname(dirname(dirname(__FILE__))) . "/question/ask_reply.json");
if ($list_all == null) {
    $list_all = [];
} else {
    $list_all = json_decode($list_all, true);
}
if ($list_reply == null) {
    $list_reply = [];
} else {
    $list_reply = json_decode($list_reply, true);
}

$ask_detail = $list_all[$id];

if($mode == 'reply'){
    $list_wait = file_get_contents(dirname(dirname(dirname(__FILE__))) . "/question/ask_wait.json");
    if ($list_wait == null) {
        $list_wait = [];
    } else {
        $list_wait = json_decode($list_wait, true);
    }

    $content['status'] = 1;
    $ask_detail['reply'] = 1;

    unset($list_wait[$id]);
    $list_reply[$id] = $ask_detail;
    $list_all[$id]['reply'] = 1;

    $file_list_wait = fopen(dirname(dirname(dirname(__FILE__))) . "/question/ask_wait.json", "w");
    fwrite($file_list_wait, json_encode($list_wait));
    fclose($file_list_wait);

}

$file_list_all = fopen(dirname(dirname(dirname(__FILE__))) . "/question/ask_all.json", "w");
fwrite($file_list_all, json_encode($list_all));
fclose($file_list_all);

$file_list_reply = fopen(dirname(dirname(dirname(__FILE__))) . "/question/ask_all.json", "w");
fwrite($file_list_reply, json_encode($list_reply));
fclose($file_list_reply);


$file_ask = fopen(dirname(dirname(dirname(__FILE__)))."/question/".$id.".json", "w");
fwrite($file_ask, json_encode($content));
fclose($file_ask);

echo json_encode(array("status"=>0));