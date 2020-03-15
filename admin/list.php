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
<div class="mdui-tab mdui-tab-centered" mdui-tab>
    <a href="#example3-tab1" class="mdui-ripple">待回答问题</a>
    <a href="#example3-tab2" class="mdui-ripple">已回答问题</a>
    <a href="#example3-tab3" class="mdui-ripple">拒绝回答问题</a>
</div>
<div class="main">

    <div class="mdui-card mdui-typo card-ask-list">
        <div class="card-ask-question">
            123
        </div>
    </div>

    <div class="mdui-card mdui-typo card-ask-list">
        <div class="card-ask-question">
            123
        </div>
    </div>

</div>
</body>
</html>