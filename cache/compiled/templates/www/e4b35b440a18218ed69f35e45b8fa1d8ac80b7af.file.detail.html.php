<?php /* Smarty version Smarty-3.0.8, created on 2018-07-06 22:40:49
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\member/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:137265b3f7f7102d885-09226555%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e4b35b440a18218ed69f35e45b8fa1d8ac80b7af' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\member/detail.html',
      1 => 1530888044,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '137265b3f7f7102d885-09226555',
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
<div class="fdrs-m-detail">
    <table cellpadding="0" cellspacing="0" border="0" class="fdrs-m-detail-tb">
      <tr>
        <td class="fdrs-m-detail-l">
          <?php if ($_smarty_tpl->getVariable('array')->value['site_url']!=''){?>
          <a href="<?php echo $_smarty_tpl->getVariable('array')->value['site_url'];?>
" target="_blank"><img class="fdrs-m-logo" src="<?php echo $_smarty_tpl->getVariable('array')->value['logo_path'];?>
" /></a>
          <?php }else{ ?>
          <img class="fdrs-m-logo" src="<?php echo $_smarty_tpl->getVariable('array')->value['logo_path'];?>
" />
          <?php }?>
        </td>
        <td class="fdrs-m-detail-r"><?php echo $_smarty_tpl->getVariable('array')->value['note'];?>
</td>
      </tr>
    </table>
</div>
<script type="text/javascript">
// layui.use(['jquery'], function(){
// });
</script> 
</body>
</html>
