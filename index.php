<html lang="zh-CN">
<?php
$title = "皮皮凛的匿名提问箱";
$choice = 1;
?>
<head>
    <?php include("./layout/head.php"); ?>
</head>
<body class="mdui-theme-primary-pink mdui-theme-accent-pink">
<?php include("./layout/nav.php"); ?>
<div class="main mdui-typo">
    <p>这里是皮皮凛的提问箱~<br>你可以在这里匿名地向我提出问题，如果我愿意回答，我就会回答啦。不一定是问题，匿名的想说的话也是可以发出的哦。在我回答后，该问题与答案也会一同发布于提问列表和其他平台（ 比如我的<a
                href="https://twitter.com/AyagawaSeirin" target="_blank">Twitter</a> ）</p>
    <p>除邮箱外我们不会记录你的任何信息，邮箱也是选择性填写，填写后会将回答结果以邮件形式发送给你~</p>

    <!--        <form action="" method="post" id="formAsk">-->
    <div class="mdui-textfield" style="padding-top:0;">
        <label class="mdui-textfield-label">提问内容</label>
        <textarea class="mdui-textfield-input input-text" id="text"></textarea>
    </div>
    <div class="mdui-textfield">
        <input class="mdui-textfield-input" type="text" id="email" placeholder="邮箱(选填)"/>
        <div class="mdui-textfield-helper">如果你填写了邮箱，回答结果会以邮件形式发送给你~</div>
    </div>
    <input type="button" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent mdui-center"
           style="margin-top: 5px" id="submitAsk" VALUE="提交">
    <!--        </form>-->
    <script src="/lib/geetest/static/gt.js"></script>
    <script type="text/javascript" language="javascript">
        var handler = function (captchaObj) {
            captchaObj.onReady(function () {
                $("#wait").hide();
            }).onSuccess(function () {
                var result = captchaObj.getValidate();
                if (!result) {
                    return alert('请完成验证');
                }
                $.ajax({
                    url: "/php/submit.php",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        username: $('#text').val(),
                        password: $('#email').val(),
                        geetest_challenge: result.geetest_challenge,
                        geetest_validate: result.geetest_validate,
                        geetest_seccode: result.geetest_seccode
                    },
                    beforeSend: function () {
                        $("#submitAsk").attr("disabled", "disabled");
                        $("#submitAsk").val("正在提交...");
                    },
                    success: function (data) {
                        $("#submitAsk").removeAttr("disabled");
                        $("#submitAsk").val("提交");
                        if (data.status != 0) {
                            mdui.alert(data.msg, '出错啦!');
                        } else {
                            mdui.alert('匿名问题提交成功啦!~', '成功啦~');
                        }
                    },

                });
            });
            // console.log($('#submit'));
            $('#submitAsk').click(function () {
                // 调用之前先通过前端表单校验
                if ($('#email').val() == '') {
                    mdui.confirm('你确定不填写邮箱么qwq?这样将无法及时收到回复呢~', '再等等!',
                        function () {
                            captchaObj.verify();
                        },
                        function () {

                        },
                        {
                            confirmText: "确定",
                            cancelText: "回去填写邮箱"
                        }
                    );
                }
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
</div>

</body>
</html>