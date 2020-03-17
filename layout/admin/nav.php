<div class="mdui-appbar mdui-appbar-fixed">
    <div class="mdui-toolbar mdui-color-theme">
        <div class="mdui-typo-title" style="margin: 0 auto;">后台管理 - 匿名提问箱</div>
    </div>
    <div class="mdui-tab mdui-color-theme mdui-tab-centered" mdui-tab>
        <a href="#" onclick="location.href='/admin/list.php'" class="mdui-ripple mdui-ripple-white <?echoclass($choice,1)?>">提问列表</a>
        <a href="#" onclick="location.href='/admin/log.php'" class="mdui-ripple mdui-ripple-white <?echoclass($choice,2)?>">安全记录</a>
        <a href="#" onclick="location.href='/'" class="mdui-ripple mdui-ripple-white">返回前台</a>
    </div>
</div>

<?php
function echoclass($choice,$now){
    if($choice == $now){
        echo "mdui-tab-active";
    }
}
?>