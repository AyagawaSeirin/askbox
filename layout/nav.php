<div class="mdui-appbar mdui-appbar-fixed">
    <div class="mdui-toolbar mdui-color-theme">
<!--        <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">live_help</i></a>-->
        <div class="mdui-typo-title" style="margin: 0 auto;">皮皮凛的提问箱</div>
<!--        <div class="mdui-toolbar-spacer"></div>-->
<!--        <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">search</i></a>-->
<!--        <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">refresh</i></a >-->
<!--        <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">more_vert</i></a>-->
    </div>
    <div class="mdui-tab mdui-color-theme mdui-tab-centered" mdui-tab>
        <a href="#" onclick="location.href='/'" class="mdui-ripple mdui-ripple-white <?echoclass($choice,1)?>">匿名提问</a>
        <a href="#" onclick="location.href='/list.php'" class="mdui-ripple mdui-ripple-white <?echoclass($choice,2)?>">提问列表</a>
        <a href="#" onclick="location.href='/about.php'" class="mdui-ripple mdui-ripple-white <?echoclass($choice,3)?>">关于</a>
    </div>
</div>

<?php
function echoclass($choice,$now){
    if($choice == $now){
        echo "mdui-tab-active";
    }
}
?>