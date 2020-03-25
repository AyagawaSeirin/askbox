<html lang="zh-CN">
<?php
require_once dirname(dirname(__FILE__)) . '/config.php';
require_once dirname(dirname(__FILE__)) . '/php/admin/checklogin.php';
$title = "回复提问 - 匿名提问箱控制台";
$choice = 1;
$id = $_GET['id'];
$content = json_decode(file_get_contents(dirname(dirname(__FILE__)) . "/question/" . $id . ".json"),true);
?>
<head>
    <?php include(dirname(dirname(__FILE__)) . "/layout/head.php"); ?>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="mdui-theme-primary-pink mdui-theme-accent-pink">
<?php include(dirname(dirname(__FILE__)) . "/layout/admin/nav.php"); ?>
<div class="main" id="main">
    <div class="mdui-card mdui-typo card-title">
        <a href="/admin/list.php">< 返回列表</a>
        <p class="mdui-float-right" style="margin-right: 5px;"><?=date("Y-m-d H:i:s",$content['creat_time'])?></p>
    </div>
    <div class="mdui-card mdui-typo card-content">
     <?=$content['content']?>
    </div>
    <div class="mdui-card mdui-typo card-content">
        <div class="mdui-textfield" style="padding-top:0;">
            <label class="mdui-textfield-label">回复内容</label>
            <textarea class="mdui-textfield-input input-text" id="text"><?=$content['reply']?></textarea>
        </div>
        <div class="" style="text-align: center;padding-bottom:5px;">
            <input type="button" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent"
                   style="margin-top: 5px" id="submitReply" value="确认回复">
            <input type="button" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent"
                   style="margin-top: 5px" id="submitSave" value="保存草稿">
        </div>
    </div>
    <script>
        $('#submitReply').click(function () {
            if($('#text').val() == ''){
                mdui.alert('请输入回答内容~', '出错啦!');
            }
            $.ajax({
                url: "/php/admin/save.php?mode=reply&id=<?=$id?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    text: $('#text').val(),
                },
                beforeSend: function () {
                    $("#submitReply").attr("disabled", "disabled");
                    $("#submitReply").val("正在提交...");
                },
                success: function (data) {
                    $("#submitReply").removeAttr("disabled");
                    $("#submitReply").val("提交");
                    if (data.status != 0) {
                        mdui.alert(data.msg, '出错啦!');
                    } else {
                        // mdui.alert('匿名提问提交成功啦!~<br>提问id:'+data.id+'<br>你可以根据这个id查询提问状态~', '成功啦~');
                    }
                },

            });
        });
        $('#submitSave').click(function () {
            $.ajax({
                url: "/php/admin/save.php?mode=draft&id=<?=$id?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    text: $('#text').val(),
                },
                beforeSend: function () {
                    $("#submitSave").attr("disabled", "disabled");
                    $("#submitSave").val("正在保存...");
                },
                success: function (data) {
                    $("#submitSave").removeAttr("disabled");
                    $("#submitSave").val("提交");
                    if (data.status != 0) {
                        mdui.alert(data.msg, '出错啦!');
                    } else {
                        mdui.alert('草稿保存成功~', '成功啦~');
                    }
                },

            });
        });
    </script>
</div>
</body>
</html>
