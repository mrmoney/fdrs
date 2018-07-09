<?php /* Smarty version Smarty-3.0.8, created on 2018-06-21 22:51:34
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\shop/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:198175b2bbb7617b3b9-01533342%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2da6eb0179e91053cad5e98ceea72856e5d26de3' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\shop/detail.html',
      1 => 1527916968,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '198175b2bbb7617b3b9-01533342',
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
<link href="/resource/css/ussv.layui.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/layui/layui-2.3.min.js"></script>
  <style type="text/css"> 
  html,body{ width:100%;height: 100%;margin:0;padding: 0; }
  </style>  
</head>
<body>
<div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-md12 ussv-prod-item">
            <table cellpadding="0" cellspacing="0" border="0" class="ussv-prod-item-tb">
              <tr>
                <td class="ussv-prod-item-l">
                  <div class="layui-carousel ussv-latoRegular" id="scroll1">
                    <div carousel-item>
                      <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['photos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
                      <div><img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['b_path'];?>
" /></div>
                      <?php }} ?>
                    </div>
                  </div>
                </td>
                <td class="ussv-prod-item-r">
                <div class="ussv-prod-name"><?php echo $_smarty_tpl->getVariable('data')->value['frm']['name'];?>
</div>
                <div class="ussv-prod-price">￥<?php echo $_smarty_tpl->getVariable('data')->value['frm']['price1'];?>
</div>
                <div class="ussv-prod-intro"><?php echo $_smarty_tpl->getVariable('data')->value['frm']['detail'];?>
</div>
                </td>
              </tr>
            </table>
        </div>
    </div>
</div>
<div class="ussv-close-btn-60"></div>
<script type="text/javascript">
layui.use(['element','carousel','jquery'], function(){
  var element = layui.element,carousel = layui.carousel,$ = layui.jquery;
  carousel.render({
    elem: '#scroll1'
    ,width: '100%' //设置容器宽度
   // ,height: body_h + 'px' //设置容器宽度
    ,arrow: 'always' //始终显示箭头
    ,indicator:'outside'
    //,anim: 'fade' //切换动画方式
  });

  // 添加关闭事件
  $('.ussv-close-btn-60').on('click',function(){
    var o = parent.layer.getFrameIndex(window.name);
    parent.layer.close(o);
  });

  // 修改轮播导航箭头
  $('.layui-carousel-arrow').each(function(index){
    var type = $(this).attr('lay-type');
    $(this).addClass('ussv-arrow');
    switch(type){
      case 'sub':
        $(this).html('<img src="/assets/scroll_btn-left.png" />');
        break;
      case 'add':
        $(this).html('<img src="/assets/scroll_btn-right.png" />');
        break;
    }
  });
});
</script> 
</body>
</html>
