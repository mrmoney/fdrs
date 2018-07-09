<?php /* Smarty version Smarty-3.0.8, created on 2018-06-21 22:51:06
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\lxwm-yysj-event.js" */ ?>
<?php /*%%SmartyHeaderCode:62975b2bbb5aa57d59-52423164%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'adc0049d3d0f686e1411ffd94e8c11376f5f8ca7' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\lxwm-yysj-event.js',
      1 => 1528334121,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '62975b2bbb5aa57d59-52423164',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
layui.use(['layer','jquery'], function(){
    var layer = layui.layer
    ,$ = layui.jquery;
    //顶部两个按钮
    $('.ussv-lxwm').on('click',function(){ 
      	layer.open({
    	  type: 2, title: '联系我们',
    	  closeBtn: 1, shadeClose: true,
    	  area:['580px','300px'],
    	  content: "/contact",skin:'ussv-lxwm-win',
    	});
    });

    $('.ussv-yysj').on('click',function(){ 
        layer.open({
        type: 2, title: '预约试驾',
        closeBtn: 1, shadeClose: false,
        area:['580px','320px'],
        content: "/testreq/view",skin:'ussv-yysj-win',
      });
    });
});