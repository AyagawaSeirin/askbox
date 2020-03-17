<html lang="zh-CN">
<?php
require_once dirname(dirname(__FILE__)) . '/config.php';
require_once dirname(dirname(__FILE__)) . '/php/admin/checklogin.php';
$title = "提问列表 - 匿名提问箱控制台";
$choice = 1;
?>
<head>
    <?php include(dirname(dirname(__FILE__)) . "/layout/head.php"); ?>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="mdui-theme-primary-pink mdui-theme-accent-pink">
<?php include(dirname(dirname(__FILE__)) . "/layout/admin/nav.php"); ?>
<div class="list-group">
    <div class="mdui-btn-group" style="margin: 0 auto;">
        <button type="button" id="btn-group-wait" onclick="loadlist('wait',0);" class="mdui-btn mdui-btn-active">待回答
        </button>
        <button type="button" id="btn-group-reply" onclick="loadlist('reply',0);" class="mdui-btn">已回答</button>
        <button type="button" id="btn-group-unreply" onclick="loadlist('unreply',0);" class="mdui-btn">已忽略</button>
    </div>
</div>
<!--<div id="loading" class="mdui-spinner mdui-center loading"></div>-->
<div class="main" id="main">
</div>
<div class="list-group" id="btn-group-page" style="padding-bottom: 20px;">
    <div class="mdui-btn-group">
        <button type="button" class="mdui-btn" id="btn-page-first"><<</button>
        <button type="button" class="mdui-btn" id="btn-page-previous"><</button>
        <button type="button" class="mdui-btn" id="btn-page-number">第1/1页</button>
        <button type="button" class="mdui-btn" id="btn-page-next">></button>
        <button type="button" class="mdui-btn" id="btn-page-last">>></button>
    </div>
</div>
<script>
    loadlist("wait", 1);

    function loadlist(type, page) {
        if (type == 'none') {
            type = global_type;
        } else {
            global_type = type;
        }
        if (page == 0) {
            page = global_page;
        } else {
            global_page = page;
        }
        $('#loading').attr("style", "display:block;");
        $('#btn-group-wait').removeClass("mdui-btn-active");
        $('#btn-group-reply').removeClass("mdui-btn-active");
        $('#btn-group-unreply').removeClass("mdui-btn-active");
        $('#btn-group-' + type).addClass("mdui-btn-active");
        $('#main').empty();
        var html = '<div class="mdui-card mdui-typo card-ask-list" id="{id}"><div class="card-ask-question">[{id}]{content}</div><div class="card-ask-time">{time}</div>{btngroup}</div>';
        if (type == 'wait') {
            var btn_group_html = '<div class="mdui-btn-group"><button type="button" onclick="location.href=\'/admin/reply.php?id={id}\';" class="mdui-btn mdui-btn-dense">回答</button><button type="button" class="mdui-btn mdui-btn-dense" onclick="to_unreply({id});">忽略</button><button type="button" class="mdui-btn mdui-btn-dense" onclick="to_delete({id},1);">删除</button></div>';
        } else if (type == 'reply') {
            var btn_group_html = '<div class="mdui-btn-group"><a type="button"  href="/admin/reply.php?id={id}" class="mdui-btn mdui-btn-dense">编辑</a><button type="button" class="mdui-btn mdui-btn-dense" onclick="to_wait({id},1);">移至待回答</button></div>';
        } else if (type == 'unreply') {
            var btn_group_html = '<div class="mdui-btn-group"><button type="button" class="mdui-btn mdui-btn-dense" onclick="to_wait({id},2);">移至待回答</button><button type="button" class="mdui-btn mdui-btn-dense" onclick="to_delete({id},2);">删除</button></div>';
        }
        $.ajax({
            url: "/php/admin/getlist.php?type=" + type + "&page=" + page + "&amount=5",
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
            },
            success: function (data) {
                $('#loading').attr("style", "display:none;");
                if (data.length == 0) {
                    global_page_amount = 1;
                }
                for (var t = 0, len = data.length; t < len; t++) {
                    var btn_group = btn_group_html.replace("{id}", data[t]['id']).replace("{id}", data[t]['id']).replace("{id}", data[t]['id']);

                    var item = html.replace("{content}", data[t]['content'])
                        .replace("{time}", data[t]['time'])
                        .replace("{id}", data[t]['id'])
                        .replace("{id}", data[t]['id'])
                        .replace("{btngroup}", btn_group);
                    $('#main').append(item);

                    if (t == 0) {
                        global_page_amount = data[t]['pageamount'];
                    }
                }

                //处理翻页
                $('#btn-page-first').removeAttr("disabled");
                $('#btn-page-previous').removeAttr("disabled");
                $('#btn-page-next').removeAttr("disabled");
                $('#btn-page-last').removeAttr("disabled");
                if (page == 1) {
                    $('#btn-page-first').attr("disabled", "true");
                    $('#btn-page-previous').attr("disabled", "true");
                }
                if (page == global_page_amount) {
                    $('#btn-page-next').attr("disabled", "true");
                    $('#btn-page-last').attr("disabled", "true");
                }

                $('#btn-page-number').text('第' + page + '/' + global_page_amount + '页');
            },

        });
    }

    function to_unreply(id) {
        $.ajax({
            url: "/php/admin/tounreply.php?id=" + id,
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
            },
            success: function (data) {
                $('#' + id).remove();
                mdui.snackbar({
                    message: '已将提问' + id + '忽略'
                });
            },
        });
    }

    function to_wait(id, by) {
        $.ajax({
            url: "/php/admin/towait.php?id=" + id + "&by=" + by,
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
            },
            success: function (data) {
                $('#' + id).remove();
                mdui.snackbar({
                    message: '已将提问' + id + '移至待回答'
                });
            },
        });
    }

    function to_delete(id, by) {
        $.ajax({
            url: "/php/admin/todelete.php?id=" + id + "&by=" + by,
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
            },
            success: function (data) {
                $('#' + id).remove();
                mdui.snackbar({
                    message: '提问' + id + '已删除'
                });
            },
        });
    }


    $('#btn-page-first').click(function () {
        loadlist("none", 1);
    });

    $('#btn-page-previous').click(function () {
        loadlist("none", global_page - 1);
    });

    $('#btn-page-next').click(function () {
        loadlist("none", global_page + 1);
    });

    $('#btn-page-last').click(function () {
        loadlist("none", global_page_amount);
    });

    $('#btn-page-number').click(function () {
        mdui.prompt('请输入页码', '跳转至指定页码(共' + global_page_amount + '页)',
            function (value) {
                if(value == '')   return;
                if (value <= global_page_amount && value > 0) {
                    loadlist("none", value);
                } else {
                    mdui.alert('页码不合法', '跳转失败');
                }
            }
        );
    });


</script>
</body>
</html>