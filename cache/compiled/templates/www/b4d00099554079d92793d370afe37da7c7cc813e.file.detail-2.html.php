<?php /* Smarty version Smarty-3.0.8, created on 2018-07-06 22:48:13
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\member/detail-2.html" */ ?>
<?php /*%%SmartyHeaderCode:9835b3f812d074d29-08784737%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b4d00099554079d92793d370afe37da7c7cc813e' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\member/detail-2.html',
      1 => 1530888464,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9835b3f812d074d29-08784737',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<DOCTYPE HTML PUBLIC "-//W3C//DTDHTML 4.0 Transitional//EN"> 
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title><?php echo $_smarty_tpl->getVariable('site_name')->value;?>
</title>
<link href="/resource/layui/css/layui.css" rel="stylesheet" media="all" />
<link href="/resource/css/fdrs.css" rel="stylesheet" media="all" />
<style type="text/css"> 
html,body{ width:100%;height: 100%;margin:0;padding: 0; }
</style>  
</head>
<body>
    <div class="fdrs-m-detail-logo-2">
      <?php if ($_smarty_tpl->getVariable('array')->value['site_url']!=''){?>
      <a href="<?php echo $_smarty_tpl->getVariable('array')->value['site_url'];?>
" target="_blank"><img class="fdrs-m-logo" src="<?php echo $_smarty_tpl->getVariable('array')->value['logo_path'];?>
" /></a>
      <?php }else{ ?>
      <img src="<?php echo $_smarty_tpl->getVariable('array')->value['logo_path'];?>
" />
      <?php }?>
    </div>
    <div class="fdrs-m-detail-2"><?php echo $_smarty_tpl->getVariable('array')->value['note'];?>
</div>
<script type="text/javascript">
// layui.use(['jquery'], function(){
// });
</script> 
</body>
</html>
