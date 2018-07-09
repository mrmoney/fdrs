<?php /* Smarty version Smarty-3.0.8, created on 2018-06-22 10:17:46
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/ussv\cms/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:316765b2c5c4a087617-25814570%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '08769203e437bac2cc77332f756f094adf232544' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/ussv\\cms/detail.html',
      1 => 1527478505,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '316765b2c5c4a087617-25814570',
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
  <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('res')->value;?>
/desktop/themes/layui/css/layui.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('res')->value;?>
/font_180510/icon_diy.css">
  <style type="text/css"> .layui-tab-item img{ max-width: 800px!important; } </style>  
</head>
<body>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
              <!-- <div class="layui-card-header">标题</div> -->
              <div class="layui-card-body">
                <div class="layui-tab">
                  <ul class="layui-tab-title">
                    <li class="layui-this">内容详情</li>
                    <li>相关照片</li>
                  </ul>
                  <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                      <?php echo $_smarty_tpl->getVariable('data')->value['frm']['detail'];?>

                    </div>
                    <div class="layui-tab-item">
                        <ul>
                            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['photos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?> 
                            <li class="item">
                                <img class="photo" src="<?php echo $_smarty_tpl->tpl_vars['item']->value['b_path'];?>
" />
                            </li>
                            <hr/>
                            <?php }} ?> 
                        </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $_smarty_tpl->getVariable('res')->value;?>
/desktop/themes/layui/layui.all.js"></script>
<script>
layui.use(['util', 'layer'], function(){
  var util = layui.util
  ,layer = layui.layer;
  //固定块
  util.fixbar({
    //bar1: '&#xe606;'
    //,bar2: true,
    css: {right: 50, bottom: 100},
    bgcolor: '#393D49',
    click: function(type){
      if(type === 'bar1'){
        layer.msg('icon是可以随便换的')
      } else if(type === 'bar2') {
        layer.msg('两个bar都可以设定是否开启')
      }
    }
  });
});
</script>
</body>
</html>
