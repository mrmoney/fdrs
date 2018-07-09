<?php /* Smarty version Smarty-3.0.8, created on 2018-06-28 09:43:18
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\v1/cms_detail.html" */ ?>
<?php /*%%SmartyHeaderCode:246205b343d3655d082-96207481%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90be7b7c45ab08574b4de0668833631586028aba' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\v1/cms_detail.html',
      1 => 1530149941,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '246205b343d3655d082-96207481',
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
						<h1 class='m-t-10 m-b-5'><?php echo $_smarty_tpl->getVariable('data')->value['frm']['topic'];?>
</h1>
						<div class="info font-weight-300">
							<span><?php echo $_smarty_tpl->getVariable('data')->value['frm']['publishtime'];?>
</span>
							<span></span>
							<span><i class="icon wb-eye m-r-5" aria-hidden="true"></i>
							1</span>
						</div>
					</section>
					<section class="met-editor clearfix"><?php echo $_smarty_tpl->getVariable('data')->value['frm']['detail'];?>
</section>
			        <div class='met-page p-y-30 border-top1'>
					    <div class="container p-t-30 ">
						    <ul class="pagination block blocks-2"'>
						        <li class='page-item m-b-0 '>
						            <a class='page-link text-truncate'>
						                上一页<span aria-hidden="true" class='hidden-xs-down'>: 自组装纳米材料的高通量组装</span>
						            </a>
						        </li>
						        <li class='page-item m-b-0 disable'>
						            <a href='javascript:;' title="" class='page-link pull-xs-right text-truncate'>
						                下一页                <span aria-hidden="true" class='hidden-xs-down'>: 没有了</span>
						            </a>
						        </li>
						    </ul>
						</div>
					</div>
                </div>
        	</div>
        
            <div class="col-md-3">
	<div class="row">
	<aside class="sidebar_met_28_1 met-sidebar panel panel-body m-b-0" 
		boxmh-h m-id='18' m-type='nocontent'>
	    	<ul class="sidebar-column list-icons">
				<li>
					<a href="/content/items/<?php echo $_smarty_tpl->getVariable('data')->value['frm']['type_id'];?>
" 
						class="active"><?php echo $_smarty_tpl->getVariable('data')->value['frm']['typename'];?>
</a>
				</li>
			</ul>
	    	<div class="sidebar-news-list recommend">
				<h3 class='font-size-16 m-0'>为你推荐</h3>
				<ul class="list-group list-group-bordered m-t-10 m-b-0">
					<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('r_rows')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
		    		<li class="list-group-item">
						<a href="/content/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['topic'];?>
</a>
					</li>
		        	<?php }} ?>
				</ul>
			</div>
	    </aside>
</div>
</div>
		</div>
    </div>
</main>
<?php $_template = new Smarty_Internal_Template('foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<script type="text/javascript">
layui.use(['carousel'], function(){
  var carousel = layui.carousel;

  carousel.render({
    elem: '#scroll1'
    ,arrow: 'always' //始终显示箭头
    ,indicator:'none'
    ,height:'372px',width:'100%'
    ,interval:2500
    ,anim: 'fade' //切换动画方式
  });

});
</script> 
</body>
</html>