<html lang="zh-CN">
<?php
require_once dirname(dirname(__FILE__)) . '/config.php';
if (isset($_COOKIE['askbox_admin'])) {
    header('location: /admin/list.php');
}
$title = "管理员登录 - 匿名提问箱";
$choice = 0;
?>
<head>
    <?php include(dirname(dirname(__FILE__)) . "/layout/head.php"); ?>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="mdui-theme-primary-pink mdui-theme-accent-pink">
<?php include(dirname(dirname(__FILE__)) . "/layout/admin/nav.php"); ?>
<div class="mdui-card main mdui-typo">
<h4 class="login-title">管理员登录</h4>
    <div class="mdui-textfield login-input">
        <input class="mdui-textfield-input" id="password" type="password" placeholder="密码"/>
    </div>
    <button class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent mdui-center login-btn" id="btn-login">登录</button>
</div>
<script src="/lib/geetest/static/gt.js"></script>
<script type="text/javascript" language="javascript">
    var handler = function (captchaObj) {
        captchaObj.onReady(function () {
            $("#wait").hide();
        }).onSuccess(function () {
            var result = captchaObj.getValidate();
            if (!result) {
                mdui.alert('请完成验证', '出错啦!');
            }
            $.ajax({
                url: "/php/admin/login.php",
                type: 'POST',
                dataType: 'json',
                data: {
                    password: $('#password').val(),
                    geetest_challenge: result.geetest_challenge,
                    geetest_validate: result.geetest_validate,
                    geetest_seccode: result.geetest_seccode
                },
                beforeSend: function () {
                    $("#btn-login").attr("disabled", "disabled");
                    $("#btn-login").val("正在登录...");
                },
                success: function (data) {
                    $("#btn-login").removeAttr("disabled");
                    $("#btn-login").val("登录");
                    if (data.status != 0) {
                        mdui.alert(data.msg, '出错啦!');
                    } else {
                        mdui.alert('登录成功~<br>正在跳转至提问列表后台');
                        setTimeout(function(){ location.href="/admin/list.php" }, 1000);
                    }
                },

            });
        });
        $('#btn-login').click(function () {
            captchaObj.verify();
        });
    };
    $.ajax({
        url: "/lib/geetest/getcode.php?t=" + (new Date()).getTime(),
        type: "get",
        dataType: "json",
        success: function (data) {

            initGeetest({
                gt: data.gt,
                challenge: data.challenge,
                offline: !data.success,
                new_captcha: data.new_captcha,

                product: "bind",
                width: "300px",
                https: true

            }, handler);
        }
    });
</script>
</body>
</html>