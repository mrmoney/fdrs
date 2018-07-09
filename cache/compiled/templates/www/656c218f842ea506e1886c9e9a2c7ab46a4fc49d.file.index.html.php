<?php /* Smarty version Smarty-3.0.8, created on 2018-07-05 15:20:41
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\subject/index.html" */ ?>
<?php /*%%SmartyHeaderCode:1665b3dc6c915e183-66976183%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '656c218f842ea506e1886c9e9a2c7ab46a4fc49d' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\subject/index.html',
      1 => 1530775225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1665b3dc6c915e183-66976183',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE HTML>
<html>
<head>
<title><?php echo $_smarty_tpl->getVariable('site_name')->value;?>
</title>
<meta name="renderer" content="webkit">
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=0,minimal-ui">
<meta name="format-detection" content="telephone=no" />
<meta name="description" content="" />
<meta name="keywords" content="研究|金融|课题|项目" />
<link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<!-- 滚动轮播 -->
<link href="/resource/layui/css/layui.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="/resource/layui/layui-2.3.min.js"></script>
<link rel='stylesheet' type='text/css' href='/resource/metinfo6/css/basic.css'>
<link rel="stylesheet" type="text/css" href="/resource/metinfo6/cache/news_cn.css"/>
<link href="/resource/css/fdrs.css" rel="stylesheet" media="all" />
<style type="text/css">

</style>
<!--[if lte IE 9]>
<script src="/resource/metinfo6/js/lteie9.js"></script>
<![endif]-->
</head>
<!--[if lte IE 8]>
<div class="text-xs-center m-b-0 bg-blue-grey-100 alert">
    你正在使用一个 <strong>过时</strong> 的浏览器。推荐安装Chrome浏览器，以提高您的体验。
</div>
<![endif]-->
<body class="met-navfixed">
<?php $_template = new Smarty_Internal_Template('head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<div class="subcolumn_nav_met_28_1 met-column-nav">
    <div class="container">
        <div class="row">
            <div class="fdrs-sidebar-tile">
                <span class="layui-breadcrumb">
                <a href="/">首页</a>
                <a><cite>研究课题</cite></a>
                </span>
            </div>
        </div>
    </div>
</div>
<main class="news_list_page_met_28_1 met-news">
    <div class="container">
        <div class="row">
            <div class="col-md-9 met-news-body">
                <div class="row">
                    <div class="met-news-list">
            	        <ul class="ulstyle met-pager-ajax imagesize" data-scale='400x400' m-id='7'>
            	        	<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('items')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
					    	<li class='border-bottom1'>
								<h4>
									<a href="/subject/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['topic'];?>
</a>
								</h4>
								<p class="des font-weight-300"><?php echo $_smarty_tpl->tpl_vars['item']->value['detail'];?>
</p>
								<p class="info font-weight-300">
									<span><?php echo $_smarty_tpl->tpl_vars['item']->value['publishtime'];?>
</span>
								</p>
							</li>
							<?php }} ?>
                    	</ul>
        	            <div class='m-t-20 text-xs-center hidden-sm-down' m-type="nosysdata">
    				        <div class='met_pager'><span class='PreSpan'>上一页</span><a class='Ahover'>1</a><span class='NextSpan'>下一页</span></div>
		            	</div>
            		</div>
                </div>
            </div>
    

            <div class="col-md-3 right_c_p">
				<div class="row"><?php $_template = new Smarty_Internal_Template('subject/right.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?></div>
			</div>
		</div>
    </div>
</main>

<?php $_template = new Smarty_Internal_Template('foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<script type="text/javascript">
layui.use(['element'], function(){
  var element = layui.element;
});
</script> 
</body>
</html>