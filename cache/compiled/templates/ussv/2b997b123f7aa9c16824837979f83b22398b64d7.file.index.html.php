<?php /* Smarty version Smarty-3.0.8, created on 2018-06-22 10:13:25
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/ussv\index.html" */ ?>
<?php /*%%SmartyHeaderCode:117295b2c5b45348ba9-25245558%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2b997b123f7aa9c16824837979f83b22398b64d7' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/ussv\\index.html',
      1 => 1528933176,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '117295b2c5b45348ba9-25245558',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo $_smarty_tpl->getVariable('site_name')->value;?>
</title>
  <meta name="renderer" content="webkit|ie-comp|ie-stand">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('res')->value;?>
/desktop/themes/layui/css/layui.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('res')->value;?>
/font_180510/icon_diy.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('res')->value;?>
/desktop/themes/desktop/style/desktope358.css?t">
  <script type="text/javascript" src="/resource/layui/layui-2.3.min.js"></script>
  <script type="text/javascript">
    var isTimeOut = false;//是否已经登录超时
  </script>
</head>
<body class="desktop-bg">
	<div class="" id="loading" style="position: absolute; top: 49%; left: 50%; margin-left: -73px; display:block;"><i class="layui-icon layui-anim layui-anim-rotate layui-anim-loop">ဂ</i></div>
	<!--桌面app配置参数-->
	<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('res')->value;?>
/desktop/themes/desktop/js/desktop.data.js"></script>
    <!--主桌面-->
    <div class="swiper-container desktop-container small-click" data-type="hidemenu">
    	<div class="swiper-pagination"></div>
        <div class="swiper-wrapper"></div>        
     </div>
    <!--任务栏-->
    <div class="desktop-taskbar">
        <!--div class="desktop-taskbar-pr"></div-->
        <div id="opening-menu" class="opening-menu">
            <div class="opening-menu-app-list"></div>
            <div class="opening-menu-user">
                <div class="desktop-opening-icon"></div>
                <div class="opening-menu-user-list">
                    <a title="您好，<?php echo $_smarty_tpl->getVariable('realname')->value;?>
" class="dock_tool_ziliao small-click" href="javascript:void(0)">您好，<?php echo $_smarty_tpl->getVariable('realname')->value;?>
</a>
                    <!-- <a title="实验室" data-type="test" class="dock_tool_ziliao small-click" href="javascript:void(0)">实验室</a> -->
                    <a title="修改密码" data-type="update_mypwd" class="dock_tool_ziliao small-click" href="javascript:void(0)">修改密码</a>
                    <a title="注销登录" data-type="loginout" class="dock_tool_loginout small-click" href="javascript:void(0)">注销登录</a>
                </div>
            </div>
        </div>
        <!--开始菜单-->
        <div class="layui-inline taskbar-win small-click" data-type="openingmenu">
        	<i class="iconfont icon-windows">&#xe75e;</i>
        </div>
        <!---->
        <div class="layui-inline desktop-taskbar-app-list">
        
        </div>
        <!--时间显示-->
        <div class="layui-inline taskbar-time">
            <label id="laydate-hs"></label>
            <label id="laydate-ymd"></label>
        </div>
        <div class="layui-inline taskbar-showdesktop small-click" data-type="showdesktop" title="显示桌面"></div>
    </div>
    <!--右键菜单-->
    <div class="desktop-menu">  
            <ul>  
            	<li><a href="javascript:;" class="small-click" data-type="launchFullscreen">进入全屏</a></li>  
            	<hr/>   
                <li><a href="javascript:;" class="small-click" data-type="showdesktop">显示桌面</a></li>  
                <li><a href="javascript:;" class="small-click" data-type="closeall">关闭所有</a></li>
                <!-- <li><a href="javascript:;" class="small-click" data-type="lockscreen">锁屏</a></li> -->  
                <hr/> 
                <li><a href="javascript:;" class="small-click" data-type="technicalsupport">技术支持</a></li>  
                <hr/>  
                <li><a href="javascript:;" class="small-click" data-type="loginout">注销</a></li>  
            </ul>  
        </div>  
</body>
<!-- <script src="<?php echo $_smarty_tpl->getVariable('cdn_host')->value;?>
/common/layui/2.2.2/layui.all.js"></script> -->
<script src="<?php echo $_smarty_tpl->getVariable('res')->value;?>
/desktop/themes/desktop/js/swiper.js"></script>
<script src="<?php echo $_smarty_tpl->getVariable('res')->value;?>
/desktop/themes/desktop/js/desktop.js"></script>
<!--锁屏代码-->
<div class="desktop-locking">
	<div class="locking-layout">
    	<div class="locking-cover small-click" data-type="lockingCover">
            <div class="locking-cover-calendar">
            	<div class="lcc-time">19:44</div>
                <div class="lcc-ymdw">2月15日，星期三</div>
            </div>
        </div>
        <div class="locking-unlock layui-hide">
            <div class="user-status"><img src="<?php echo $_smarty_tpl->getVariable('res')->value;?>
/desktop/themes/desktop/images/user-avatar.jpg"></div>
            <div class="user-nickname"><?php echo $_smarty_tpl->getVariable('realname')->value;?>
</div>
            <div class="user-unlock">
            	<input type="password" placeholder="您的登录密码" class="layui-input unlock-pwd">
                <i class="iconfont unlock-see-pwd">&#xe612;</i>
            </div>
        </div>
    </div>
</div>
</body>
</html>
