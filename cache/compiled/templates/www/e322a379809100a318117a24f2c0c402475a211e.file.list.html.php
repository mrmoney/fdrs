<?php /* Smarty version Smarty-3.0.8, created on 2018-06-28 18:41:41
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\v1/list.html" */ ?>
<?php /*%%SmartyHeaderCode:71775b34bb65385f40-58151456%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e322a379809100a318117a24f2c0c402475a211e' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\v1/list.html',
      1 => 1530180535,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '71775b34bb65385f40-58151456',
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
									<a href="/content/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['topic'];?>
</a>
								</h4>
								<p class="des font-weight-300"><?php echo $_smarty_tpl->tpl_vars['item']->value['detail'];?>
</p>
								<p class="info font-weight-300">
									<span><?php echo $_smarty_tpl->tpl_vars['item']->value['publishtime'];?>
</span>
									<span></span>
									<span><i class="icon wb-eye m-r-5 font-weight-300" aria-hidden="true"></i>2</span>
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
    

            <div class="col-md-3">
	<div class="row">
		<aside class="sidebar_met_28_1 met-sidebar panel panel-body m-b-0" boxmh-h m-id='8' m-type='nocontent'>
		    	<ul class="sidebar-column list-icons">
					<li><a href="/" class="active">金融聚焦</a></li>
				</ul>
		    	<div class="sidebar-news-list recommend">
		<h3 class='font-size-16 m-0'>为你推荐</h3>
				<ul class="list-group list-group-bordered m-t-10 m-b-0">
					<li class="list-group-item ">
						<a href="http://met.evgo.me/news/news4.html" title="清北大学纳米研究所在柔性电子器件方面取得重要进展" target=_self class="">清北大学纳米研究所在柔性电子器件方面取得重要进展</a>
					</li>
									<li class="list-group-item ">
				<a href="http://met.evgo.me/news/news3.html" title="中国国际石墨烯创新大会召开" target=_self class="">中国国际石墨烯创新大会召开</a>
			</li>
									<li class="list-group-item ">
				<a href="http://met.evgo.me/news/news2.html" title="清北大学研究所承办第5期学科论坛" target=_self class="active">清北大学研究所承办第5期学科论坛</a>
			</li>
									<li class="list-group-item ">
				<a href="http://met.evgo.me/news/news1.html" title="西北大学李副教授访问清北大学纳米研究所" target=_self class="">西北大学李副教授访问清北大学纳米研究所</a>
			</li>
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