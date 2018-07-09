<?php /* Smarty version Smarty-3.0.8, created on 2018-06-28 10:27:08
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\../500.html" */ ?>
<?php /*%%SmartyHeaderCode:34435b34477c985a44-04769148%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '782cb953e45ed98f55518190128b48b1c6889d0d' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\../500.html',
      1 => 1530150547,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '34435b34477c985a44-04769148',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title><?php echo $_smarty_tpl->getVariable('site_name')->value;?>
</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="apple-mobile-web-app-status-bar-style" content="black"> 
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="format-detection" content="telephone=no">
  <link rel="stylesheet" type="text/css" href="/resource/desktop/themes/layui/css/layui.css">
  <link rel="stylesheet" type="text/css" href="/resource/layui/sys-style-2.3.css">
  <style type="text/css">
    .layui-text h2{margin-bottom:10px;font-weight:600;font-size:20px;color:#33378c}
    .layui-text p{ color:#33378c }
    body,html{ overflow: hidden; }
    .layadmin-tips h1{ color:#0094d7; }
    .layadmin-tips .layui-text{ border-top-color: #0094d7; }
    <?php if ($_smarty_tpl->getVariable('face_size')->value==null){?>
    .layadmin-tips .layui-icon[face]{ font-size: 100px; color: #0094d7; }
    <?php }else{ ?>
    .layadmin-tips .layui-icon[face]{ font-size: <?php echo $_smarty_tpl->getVariable('face_size')->value;?>
px; color: #0094d7; }
    <?php }?>
  </style>
</head>
<body>
<div class="layui-fluid">
  <div class="layadmin-tips">
    <i class="layui-icon" face>&#xe664;</i>
    <div class="layui-text">
      <h2><?php echo $_smarty_tpl->getVariable('title')->value;?>
</h2>
      <p><?php echo $_smarty_tpl->getVariable('content')->value;?>
</p>
    </div>
  </div>
</div>
</body>
</html>
