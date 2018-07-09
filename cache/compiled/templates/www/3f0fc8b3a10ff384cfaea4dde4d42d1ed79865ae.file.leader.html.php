<?php /* Smarty version Smarty-3.0.8, created on 2018-06-28 16:43:19
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\member/leader.html" */ ?>
<?php /*%%SmartyHeaderCode:33185b349fa72682c9-94363964%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3f0fc8b3a10ff384cfaea4dde4d42d1ed79865ae' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\member/leader.html',
      1 => 1530175395,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '33185b349fa72682c9-94363964',
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
<script src="http://met.evgo.me/public/ui/v2/static/js/lteie9.js"></script>
<![endif]-->
</head>
<!--[if lte IE 8]>
<div class="text-xs-center m-b-0 bg-blue-grey-100 alert">
    你正在使用一个 <strong>过时</strong> 的浏览器。推荐安装Chrome浏览器，以提高您的体验。
</div>
<![endif]-->
<body class="met-navfixed">
<header class="head_nav_met_27_1 navbar-fixed-top" m-id='39' m-type="head_nav">
<div class="container top-box">
		<div class="row">
			<div class="top-header">
				<div class="logo-box">
				    <a href="http://met.evgo.me/" class="met-logo" title="广东省金融发展研究会">
				        <h1 hidden>广东省金融发展研究会</h1>
				        <div class="vertical-align-middle">
					        <img src="/images/logo-500-62.png" alt="广东省金融发展研究会"/>
					    </div>
				    </a>
				</div>
				<div class="pull-md-right hidden-sm-down">
					<ul class="met-langlist pull-md-left m-b-0"></ul>
				    <div class="met-search-body pull-md-left">
				    <form method='get' class="page-search-form" role="search" 
				    	action='http://met.evgo.me/search/search.php?lang=cn'>
				        <input type='hidden' name='lang' value='cn' />
				        <input type='hidden' name='class1' value='' />
				        <div class="input-search">
				            <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
				            <input type="text" class="form-control" name="searchword" 
				                placeholder="搜索" data-fv-notempty = "true" />
				        </div>
				    </form>
				</div>
			</div>
			<button type="button" class="navbar-toggler hamburger hamburger-close collapsed  met-nav-toggler" data-target="#met-nav-collapse" data-toggle="collapse">
			    <span class="sr-only"></span>
			    <span class="hamburger-bar"></span>
			</button>
		</div>

	</div>
</div>

<div class="container">
    <div class="row">
	    <nav class="navbar navbar-default box-shadow-none head_nav_met_27_1-navbar navlist" >
		    <div class="collapse navbar-collapse navbar-collapse-toolbar pull-md-left p-0" id="met-nav-collapse">
		        <ul class="nav navbar-nav navlist daohang  flex">
		        	<?php  $_smarty_tpl->tpl_vars['menu'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('menus')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['menu']->key => $_smarty_tpl->tpl_vars['menu']->value){
?>
		            <li class='nav-item'>
		            	<?php if ($_smarty_tpl->getVariable('cat_id')->value==$_smarty_tpl->tpl_vars['menu']->value['index']){?>
		                <a href="<?php echo $_smarty_tpl->tpl_vars['menu']->value['href'];?>
" class="nav-link active"><?php echo $_smarty_tpl->tpl_vars['menu']->value['text'];?>
</a>
		            	<?php }else{ ?>
		                <a href="<?php echo $_smarty_tpl->tpl_vars['menu']->value['href'];?>
" class="nav-link"><?php echo $_smarty_tpl->tpl_vars['menu']->value['text'];?>
</a>
		            	<?php }?>
		            </li>
		        	<?php }} ?>
		        </ul>
		    </div>
	    </nav>
    </div>
    </div>
</header>


 <main class="news_list_detail_met_16_1 met-shownews animsition">
	<div class="container">
		<div class="row">
		    <div class="col-md-9 met-shownews-body" m-id='17'>
                <div class="row">
                	<section class="details-title border-bottom1">
						<h1 class='m-t-10 m-b-5'>研究会会员</h1>
					</section>
					<section class="met-editor clearfix">
						<div class="layui-fluid">
						    <div class="layui-row layui-col-space15">
						        <div class="layui-col-md12">
						            <div class="layui-card">
						              <div class="layui-card-body">
						                <div class="layui-tab">
						                  <ul class="layui-tab-title">
						                    <li class="layui-this">会长/副会长/秘书长</li>
						                    <li>监事会</li>
						                    <li>理事会</li>
						                  </ul>
						                  <div class="layui-tab-content">
						                    <div class="layui-tab-item layui-show">
						                      <?php echo $_smarty_tpl->getVariable('config_2_5')->value['detail'];?>

						                    </div>
						                    <div class="layui-tab-item">
						                      <?php echo $_smarty_tpl->getVariable('config_2_6')->value['detail'];?>

						                    </div>
						                    <div class="layui-tab-item">
						                      <?php echo $_smarty_tpl->getVariable('config_2_7')->value['detail'];?>

						                    </div>
						                  </div>
						                </div>
						              </div>
						            </div>
						        </div>
						    </div>
						</div>
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