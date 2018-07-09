<?php /* Smarty version Smarty-3.0.8, created on 2018-06-22 10:12:27
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/default\login.admin.html" */ ?>
<?php /*%%SmartyHeaderCode:112895b2c5b0bd91c18-25048219%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9da6b926e8024eb56c97852862c35f5793d85c57' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/default\\login.admin.html',
      1 => 1529633546,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '112895b2c5b0bd91c18-25048219',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $_smarty_tpl->getVariable('site_name')->value;?>
</title>
    <link href="/resource/login/css/login.css" rel="stylesheet" type="text/css" />
    <script src="/resource/login/js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="/resource/login/js/cloud.js" type="text/javascript"></script>
    <script type="text/javascript" src="/resource/jsencrypt.min.js"></script>  
    <script language="javascript">
        jQuery.fn.serializeObject = function() {  
             var o = {};  
             var a = this.serializeArray();  
             $.each(a, function() {  
                 if (o[this.name] !== undefined) {  
                     if (!o[this.name].push) { o[this.name] = [o[this.name]]; }  
                     o[this.name].push(this.value || '');  
                 } else {  
                     o[this.name] = this.value || '';  
                }  
            });  
            return o;  
        }; 

        $(function(){
            $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
            $(window).resize(function(){
                $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
            });

            //得到焦点
            $("#password").focus(function(){
                $("#left_hand").animate({
                    left: "150",
                    top: " -38"
                },{step: function(){
                    if(parseInt($("#left_hand").css("left"))>140){
                        $("#left_hand").attr("class","left_hand");
                    }
                }}, 2000);
                $("#right_hand").animate({
                    right: "-64",
                    top: "-38px"
                },{step: function(){
                    if(parseInt($("#right_hand").css("right"))> -70){
                        $("#right_hand").attr("class","right_hand");
                    }
                }}, 2000);
            });

            //失去焦点
            $("#password").blur(function(){
                $("#left_hand").attr("class","initial_left_hand");
                $("#left_hand").attr("style","left:100px;top:-12px;");
                $("#right_hand").attr("class","initial_right_hand");
                $("#right_hand").attr("style","right:-112px;top:-12px");
            });
        });

        var pub_key = '<?php echo $_smarty_tpl->getVariable('public_key')->value;?>
';
        function check_user()
        {
            var tips_c = $('#tips_c');
            tips_c.text('');
            var frm = $("#frm_login");
            var data = frm.serializeObject();
            data.username = (data.username).trim();
            if(data.username.length <= 3){
                tips_c.text('您输入的用户名不正确');
                return false;
            }

            if(data.userpwd.length <= 3){
                tips_c.text('您输入登录密码');
                return false;
            }

            var encrypt = new JSEncrypt();
            encrypt.setPublicKey(pub_key);
            data.userpwd = encrypt.encrypt(data.userpwd); 

            //console.log(data);
            tips_c.text('正在验证...');

            $.ajax({
              url: '/?app=sysauth_controller_default&act=check',
              method:'post',dataType: 'json',
              data: data, 
              success: function(json){
                //console.log(json);
                try{
                    if(json.code != 1){
                        tips_c.text(json.message);
                    }else{
                        location.href = json.data;
                    }
                }catch(err){
                    tips_c.text('服务器繁忙');
                }
              }
            });

            return false;
        }
    </script>

</head>

<body class="main">

<div id="mainBody">
    <div id="cloud1" class="cloud"></div>
    <div id="cloud2" class="cloud"></div>
</div>

<div class="logintop">
    <span>欢迎登录后台管理系统</span>
    <ul>
        <li><a href="/">回首页</a></li>
    </ul>
</div>

<div class="loginbody">
    <span class="systemlogo"></span>
    <div class="loginbox">
        <DIV style="width:165px; height:96px; position:absolute;top:8px;left:-70px">
            <DIV class="tou"></DIV>
            <DIV class="initial_left_hand" id="left_hand"></DIV>
            <DIV class="initial_right_hand" id="right_hand"></DIV>
        </DIV>
        <form id="frm_login" method="post" onsubmit="return check_user()">
            <ul>
                <li><input name="username" id="username" type="text" class="loginuser ipt" 
                        placeholder="请输入用户名/手机号码" value="mrmoney" /></li>
                <li><input name="userpwd" id="userpwd" type="password" class="loginpwd ipt" 
                        placeholder="请输入密码" value="a123456" /></li>
                <li><input type="button" class="loginbtn" value="登录" onclick="return check_user()" />
                <label><a id="tips_c"></a></label>
                <!-- <label><input name="" type="checkbox" value="" checked="checked" />记住密码</label><label>忘记密码？</label> --></li>
            </ul>
        </form>
    </div>
</div>
<div class="loginbm">版权所有 2018 <?php echo $_smarty_tpl->getVariable('site_name')->value;?>
</div>
</body>
</html>
