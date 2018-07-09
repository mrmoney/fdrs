<?php /* Smarty version Smarty-3.0.8, created on 2018-07-05 13:41:23
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\member/index.html" */ ?>
<?php /*%%SmartyHeaderCode:270015b3daf83136978-23007634%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e3f635ab99c5f8a8d20d06274f76de8df21de541' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\member/index.html',
      1 => 1530761774,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '270015b3daf83136978-23007634',
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
<link rel="stylesheet" type="text/css" href="/resource/metinfo6/cache/shownews_cn.css"/>
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
                  <a><cite>研究会成员</cite></a>
                  <a><cite><?php echo $_smarty_tpl->getVariable('title_text')->value;?>
</cite></a>
                </span>
            </div>
        </div>
    </div>
</div>
 <main class="news_list_detail_met_16_1 met-shownews animsition">
	<div class="container">
		<div class="row">
		    <div class="col-md-9 fdrs-card-shadow">
                <div class="row">
                	<section class="details-title border-bottom1">
						<h1 class='m-t-10 m-b-5'><img src="/images/fdrs/member_club_sign.png" />
                        <?php echo $_smarty_tpl->getVariable('title_text')->value;?>
</h1>
					</section>
					<section class="met-editor clearfix"><?php echo $_smarty_tpl->getVariable('config')->value['detail'];?>
</section>
	            </div>
        	</div>
        
            <div class="col-md-3 right_c_p">
				<div class="row"><?php $_template = new Smarty_Internal_Template('member/right.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
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