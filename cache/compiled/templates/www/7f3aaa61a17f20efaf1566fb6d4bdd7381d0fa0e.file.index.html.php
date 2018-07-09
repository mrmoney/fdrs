<?php /* Smarty version Smarty-3.0.8, created on 2018-07-06 15:34:18
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\index.html" */ ?>
<?php /*%%SmartyHeaderCode:191395b3f1b7a4231b7-48062112%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7f3aaa61a17f20efaf1566fb6d4bdd7381d0fa0e' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\index.html',
      1 => 1530862260,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '191395b3f1b7a4231b7-48062112',
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
<link rel="stylesheet" type="text/css" href="/resource/metinfo6/cache/index_cn.css"/>
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
<div class="news_list_met_27_1 met-index-body newsbox     bgpic" m-id='38'>
	<div class="container newsbox" >
		<!--左边新闻(带轮播图)-->
		<div class="row">
			<div class="item col-xs-12 col-md-9">
		        <div class="met-index-imgnews">
			        <div class="left-news">
				        <div class="left-img ussv-home-scroll1">
				        	<div class="layui-carousel" id="scroll1">
				  				<div carousel-item>
				        			<?php  $_smarty_tpl->tpl_vars['photo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('photos_focus')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['photo']->key => $_smarty_tpl->tpl_vars['photo']->value){
?>
				        			<?php if ($_smarty_tpl->tpl_vars['photo']->value['content_id']>0){?>
									<div class="ussv-detail-link" item-id="<?php echo $_smarty_tpl->tpl_vars['photo']->value['content_id'];?>
"><a href="/content/<?php echo $_smarty_tpl->tpl_vars['photo']->value['content_id'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['photo']->value['b_path'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['photo']->value['title'];?>
" /></a></div>
									<?php }elseif($_smarty_tpl->tpl_vars['photo']->value['subject_id']>0){?>
									<div class="ussv-detail-link" item-id="<?php echo $_smarty_tpl->tpl_vars['photo']->value['subject_id'];?>
"><a href="/subject/<?php echo $_smarty_tpl->tpl_vars['photo']->value['subject_id'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['photo']->value['b_path'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['photo']->value['title'];?>
" /></a></div>
									<?php }else{ ?>
									<div><img src="<?php echo $_smarty_tpl->tpl_vars['photo']->value['b_path'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['photo']->value['title'];?>
" /></div>
									<?php }?>
									<?php }} ?>
					        	</div>
				        	</div>
				        </div>
				    </div>
				</div>
	        </div>
        	<div class="item col-xs-12 col-md-3">
                <div class="met-index-imgnews">
                	<div class="main1">
			        	<div class="sort">
							<a href="/contents/2" style="margin-top: 0px;">
								<p class="title">金融聚焦</p>
								<p class="title_en">Financial Focus</p>
								<em></em>
							</a>
							<a href="/contents/3">
								<p class="title">研究会动态</p>
								<p class="title_en">FDRS News</p>
								<em></em>
							</a>
							<a href="/contents/4" class="">
								<p class="title">会员动态</p>
								<p class="title_en">Member News</p>
								<em></em>
							</a>
						</div>
			        </div>
    	    	</div>
			</div>
		</div>
	</div>
</div>


<div class="news_list_met_27_3">
	<div class="container newsbox">
		<div class="row">
			<!-- 左边新闻框 -->
			<div class="item  col-xs-12  col-lg-4">
		        <div class="met-index-news ">
		            <div class="title clearfix">
			            <h2 class="news-h">政策法规</h2>
			            <p class="news-desc">Policy</p>
		            </div>
		            <?php if ($_smarty_tpl->getVariable('zcfg_num')->value<=4){?>
			        <div class="left-img fdrs-scroll">
			        	<div class="layui-carousel" id="scroll_zcfg">
			  				<div carousel-item>
			        			<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('zcfg')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
								<div class="fdrs-home-scroll">
									<h4>
										<a href="/content/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">
			                                <?php echo $_smarty_tpl->tpl_vars['row']->value['topic'];?>
			
			                            </a>
									</h4>
				            		<div class="right-img">
										<?php echo $_smarty_tpl->tpl_vars['row']->value['detail'];?>

								    </div>
								</div>
								<?php }} ?>
				        	</div>
			        	</div>
			        </div>
			        <?php }else{ ?>
			        <ul class="news-list fdrs-home-min-h">
			        	<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('zcfg')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
		        		<li>
							<a href="/content/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">
							<span><?php echo $_smarty_tpl->tpl_vars['row']->value['publishtime'];?>
</span>
							<?php echo $_smarty_tpl->tpl_vars['row']->value['topic'];?>
</a>
						</li>
			        	<?php }} ?>
			        </ul>
			        <div class="more">
					   <a href="/contents/5">更多</a>
			        </div>
			        <?php }?>
			    </div>
		    </div>
		    <!-- 左边新闻框 -->
		    
		    <!--中间新闻框-->
		    <div class="item  col-xs-12 col-lg-4">
		        <div class="met-index-news">
			        <div class="title clearfix">
			            <h2 class="news-h">研究课题</h2>
			            <p class="news-desc">Subject study</p>
		            </div>
		            <?php if ($_smarty_tpl->getVariable('subject_num')->value<=4){?>
			        <div class="left-img fdrs-scroll">
			        	<div class="layui-carousel" id="scroll_yjkt">
			  				<div carousel-item>
			        			<?php  $_smarty_tpl->tpl_vars['subject'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('subjects')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['subject']->key => $_smarty_tpl->tpl_vars['subject']->value){
?>
								<div class="fdrs-home-scroll">
									<h4>
										<a href="/subject/<?php echo $_smarty_tpl->tpl_vars['subject']->value['id'];?>
">
											<i class="icon pe-angle-right"></i>
			                                <?php echo $_smarty_tpl->tpl_vars['subject']->value['topic'];?>
			
			                            </a>
									</h4>
				            		<div class="right-img">
										<?php echo $_smarty_tpl->tpl_vars['subject']->value['detail'];?>

								    </div>
								</div>
								<?php }} ?>
				        	</div>
			        	</div>
			        </div>
			        <?php }else{ ?>
			        <ul class="news-list fdrs-home-min-h">
			        	<?php  $_smarty_tpl->tpl_vars['subject'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('subjects')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['subject']->key => $_smarty_tpl->tpl_vars['subject']->value){
?>
		        		<li>
							<a href="/subject/<?php echo $_smarty_tpl->tpl_vars['subject']->value['id'];?>
">
							<span><?php echo $_smarty_tpl->tpl_vars['subject']->value['publishtime'];?>
</span>
							<?php echo $_smarty_tpl->tpl_vars['subject']->value['topic'];?>
</a>
						</li>
			        	<?php }} ?>
			        </ul>
			        <div class="more">
					   <a href="/subject/index">更多</a>
			        </div>
			        <?php }?>
			    </div>
		    </div>
		    <!--中间新闻框-->
		    <!--右侧展示区块-->
		    <div class="item col-xs-12 col-lg-4">
				<div class="met-index-product">
					<div class="container">
					    <div class="title clearfix">
					    	<h2 class="news-h">联系我们</h2>
			                <p class="news-desc">Contact</p>
						</div>
						<div class="nav-tabs-vertical fdrs-home-contact">
						    <table cellpadding="0" cellspacing="0" border="0" width="100%">
							    <tr>
							    	<td class="fdrs-home-contact-left">
										<div>电话：020-38626087</div>
										<div>邮件：hello@qq.com</div>
										<div>地址：广东省广州市天河区瘦狗岭路413号A2栋30层</div>
										<!-- <div class="more"><a>扫码关注我们</a></div> -->
							    	</td>
							    	<td class="fdrs-home-qrcode"><img src="/images/gzh.jpg">
							    	<div>扫码关注我们</div></td>
							    </tr>
						    </table>
	                    </div>
	                </div>
	            </div>
			</div>
		    <!--右侧展示区块-->
		</div>
	</div>
</div>
<?php $_template = new Smarty_Internal_Template('foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<script type="text/javascript">
layui.use(['carousel','jquery'], function(){
  var carousel = layui.carousel,$ = layui.jquery;

  carousel.render({
    elem: '#scroll1'
    ,arrow: 'always' 
    ,indicator:'none'
    ,height:'370px',width:'100%'
    ,interval:3000
    ,anim: 'fade' 
  });

  <?php if ($_smarty_tpl->getVariable('zcfg_num')->value<=4){?>
  carousel.render({
    elem: '#scroll_zcfg'
    ,arrow: 'hover' 
    ,indicator:'none'
    ,height:'186px',width:'100%'
    ,interval:3000
    ,anim: 'updown' 
  });
  <?php }?>

  <?php if ($_smarty_tpl->getVariable('subject_num')->value<=4){?>
  carousel.render({
    elem: '#scroll_yjkt'
    ,arrow: 'hover' 
    ,indicator:'none'
    ,height:'186px',width:'100%'
    ,interval:3000
    ,anim: 'updown' 
  });
  <?php }?>
  
  // home_btn_over
  $('.main1 .sort a').each(function(index){
  	var _this = this;
  	$(this).mouseover(function(){ $(_this).addClass('home_btn_over'); });
  	$(this).mouseout(function(){$(_this).removeClass('home_btn_over');});
  });

});
</script> 
</body>
</html>