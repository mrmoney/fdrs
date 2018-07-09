<?php /* Smarty version Smarty-3.0.8, created on 2018-07-07 10:28:58
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\index-2.html" */ ?>
<?php /*%%SmartyHeaderCode:205615b40256ae2f663-12030903%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e56cdd64e865aed5103af96f9b3a345706243d80' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\index-2.html',
      1 => 1530930537,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '205615b40256ae2f663-12030903',
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
<div class="news_list_met_27_2 fdrs-home-top-bg">
	<div class="container newsbox" >
		<!--左边新闻(带轮播图)-->
		<div class="row">
			<div class="item col-xs-12 col-lg-8 fdrs-scroll">
		        <div class="ussv-home-scroll1">
		        	<div class="layui-carousel" id="scroll1">
		  				<div carousel-item>
		        			<?php  $_smarty_tpl->tpl_vars['photo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('photos_focus')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['photo']->key => $_smarty_tpl->tpl_vars['photo']->value){
?>
		        			<?php if ($_smarty_tpl->tpl_vars['photo']->value['content_id']>0){?>
							<div class="fdrs-detail-link" item-id="<?php echo $_smarty_tpl->tpl_vars['photo']->value['content_id'];?>
"><a href="/content/<?php echo $_smarty_tpl->tpl_vars['photo']->value['content_id'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['photo']->value['b_path'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['photo']->value['title'];?>
" /></a></div>
							<?php }elseif($_smarty_tpl->tpl_vars['photo']->value['subject_id']>0){?>
							<div class="fdrs-detail-link" item-id="<?php echo $_smarty_tpl->tpl_vars['photo']->value['subject_id'];?>
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
        	<div class="item col-xs-12 col-lg-4">
                <div class="met-index-news fdrs-home-top-height">
			        <div class="title clearfix">
			            <h2 class="news-h">研究课题</h2>
			            <p class="news-desc">Subject study</p>
		            </div>
			        <div class="left-img fdrs-scroll">
			        	<div class="layui-carousel" id="scroll2">
			  				<div carousel-item>
			        			<?php  $_smarty_tpl->tpl_vars['subject'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('subjects')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['subject']->key => $_smarty_tpl->tpl_vars['subject']->value){
?>
								<ul class="news-list">
				            		<div class="fdrs-home-scroll fdrs-home-top-rt">
										<h4>
											<a href="/subject/<?php echo $_smarty_tpl->tpl_vars['subject']->value['id'];?>
">
				                                <?php echo $_smarty_tpl->tpl_vars['subject']->value['topic'];?>
			
				                            </a>
										</h4>
					            		<div class="right-img">
											<?php echo $_smarty_tpl->tpl_vars['subject']->value['detail'];?>

									    </div>
									    <div class="fdrs-split"></div>
									</div>
								    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['subject']->value['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
								    <li>
										<a href="/content/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
											<i class="icon pe-angle-right"></i>
			                                <?php echo $_smarty_tpl->tpl_vars['item']->value['topic'];?>
			
			                            </a>
									</li>
									<?php }} ?>
								</ul>
								<?php }} ?>
				        	</div>
			        	</div>
			        </div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="news_list_met_27_2">
	<div class="container newsbox">
		<div class="row">
			<!-- 左边新闻框 -->
			<div class="item  col-xs-12 col-lg-4">
		        <div class="met-index-news">
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
											<i class="icon pe-angle-right"></i>
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
		    <div class="item  col-xs-12  col-lg-4">
		        <div class="met-index-news">
		            <div class="title clearfix">
			            <h2 class="news-h">金融聚焦</h2>
			            <p class="news-desc">Financial Focus</p>
		            </div>
			        <?php if ($_smarty_tpl->getVariable('jrjj_num')->value<=4){?>
			        <div class="left-img fdrs-scroll">
			        	<div class="layui-carousel" id="scroll_jrjj">
			  				<div carousel-item>
			        			<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('jrjj')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
								<div class="fdrs-home-scroll">
									<h4>
										<a href="/content/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">
											<i class="icon pe-angle-right"></i>
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
 $_from = $_smarty_tpl->getVariable('jrjj')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
					   <a href="/contents/2">更多</a>
			        </div>
			        <?php }?>
			    </div>
		    </div>
		    <!--中间新闻框-->
		    <div class="item  col-xs-12 col-lg-4">
		        <div class="met-index-news">
			        <div class="title clearfix">
			            <h2 class="news-h">活动公告</h2>
			            <p class="news-desc">Activity</p>
			        </div> 
			        <?php if ($_smarty_tpl->getVariable('hdgg_num')->value<=4){?>
			        <div class="left-img fdrs-scroll">
			        	<div class="layui-carousel" id="scroll_hdgg">
			  				<div carousel-item>
			        			<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('hdgg')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
								<div class="fdrs-home-scroll">
									<h4>
										<a href="/content/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">
											<i class="icon pe-angle-right"></i>
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
 $_from = $_smarty_tpl->getVariable('hdgg')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
					   <a href="/contents/6">更多</a>
			        </div>
			        <?php }?>
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
			            <h2 class="news-h">研究会动态</h2>
			            <p class="news-desc">FDRS News</p>
			        </div> 
			        <?php if ($_smarty_tpl->getVariable('yjhdt_num')->value<=4){?>
			        <div class="left-img fdrs-scroll">
			        	<div class="layui-carousel" id="scroll_yjhdt">
			  				<div carousel-item>
			        			<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('yjhdt')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
								<div class="fdrs-home-scroll">
									<h4>
										<a href="/content/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">
											<i class="icon pe-angle-right"></i>
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
 $_from = $_smarty_tpl->getVariable('yjhdt')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
					   <a href="/contents/3">更多</a>
			        </div>
			        <?php }?>
			    </div>
		    </div>
		    <!-- 左边新闻框 -->
		    
		    <!--中间新闻框-->
		    <div class="item  col-xs-12 col-lg-4">
		        <div class="met-index-news">
			        <div class="title clearfix">
			            <h2 class="news-h">会员动态</h2>
			            <p class="news-desc">Member News</p>
		            </div>
		            <?php if ($_smarty_tpl->getVariable('hydt_num')->value<=4){?>
			        <div class="left-img fdrs-scroll">
			        	<div class="layui-carousel" id="scroll_hydt">
			  				<div carousel-item>
			        			<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('hydt')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
								<div class="fdrs-home-scroll">
									<h4>
										<a href="/content/<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">
											<i class="icon pe-angle-right"></i>
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
 $_from = $_smarty_tpl->getVariable('hydt')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
					   <a href="/contents/4">更多</a>
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

<div class="news_list_met_27_3">
	<div class="container newsbox">
		<div class="row">
			<!-- 左边新闻框 -->
			<div class="item  col-xs-12  col-lg-12">
				<div class="met-index-news" style="border: none;">
			        <div class="title clearfix">
			            <h2 class="news-h">研究会会员</h2>
			            <p class="news-desc">Members</p>
		            </div>
			        <div class="left-img fdrs-scroll">
			        	<?php if ($_smarty_tpl->getVariable('members_num')->value>0){?>
			        	<div class="layui-carousel" id="scroll_members">
			  				<div carousel-item>
			  					<?php  $_smarty_tpl->tpl_vars['member'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('members')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['member']->key => $_smarty_tpl->tpl_vars['member']->value){
?>
			        			<div>
				        			<div class="row">
				        				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['member']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
				        				<div member_id="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
" class="item col-xs-12 col-lg-2 fdrs-home-logo">
				        				<img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['logo_path'];?>
"/>
				        				</div>
			  							<?php }} ?>
				        			</div>
			        			</div>
			  					<?php }} ?>
				        	</div>
			        	</div>
			        	<?php }?>
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
layui.use(['carousel','jquery'<?php if ($_smarty_tpl->getVariable('members_num')->value>0){?>,'layer'<?php }?>], function(){
  var carousel = layui.carousel,$ = layui.jquery;

  carousel.render({
    elem: '#scroll1'
    ,arrow: 'always' 
    ,indicator:'none'
    ,height:'370px',width:'100%'
    ,interval:3000
    ,anim: 'fade' 
  });

  carousel.render({
    elem: '#scroll2'
    ,arrow: 'none' 
    ,indicator:'none'
    ,height:'370px',width:'100%'
    ,interval:5000
    ,anim: 'fade' 
  });

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

  <?php if ($_smarty_tpl->getVariable('jrjj_num')->value<=4){?>
  carousel.render({
    elem: '#scroll_jrjj'
    ,arrow: 'hover' 
    ,indicator:'none'
    ,height:'186px',width:'100%'
    ,interval:3000
    ,anim: 'updown' 
  });
  <?php }?>

  <?php if ($_smarty_tpl->getVariable('hdgg_num')->value<=4){?>
  carousel.render({
    elem: '#scroll_hdgg'
    ,arrow: 'hover' 
    ,indicator:'none'
    ,height:'186px',width:'100%'
    ,interval:3000
    ,anim: 'updown' 
  });
  <?php }?>

  <?php if ($_smarty_tpl->getVariable('yjhdt_num')->value<=4){?>
  carousel.render({
    elem: '#scroll_yjhdt'
    ,arrow: 'hover' 
    ,indicator:'none'
    ,height:'186px',width:'100%'
    ,interval:3000
    ,anim: 'updown' 
  });
  <?php }?>

  <?php if ($_smarty_tpl->getVariable('hydt_num')->value<=4){?>
  carousel.render({
    elem: '#scroll_hydt'
    ,arrow: 'hover' 
    ,indicator:'none'
    ,height:'186px',width:'100%'
    ,interval:3000
    ,anim: 'updown' 
  });
  <?php }?>

  <?php if ($_smarty_tpl->getVariable('members_num')->value>0){?>
  carousel.render({
    elem: '#scroll_members'
    ,arrow: 'none' 
    ,indicator:'none'
    ,height:'120px',width:'100%'
    ,interval:3000
    ,anim: 'updown' 
  });

  var layer = layui.layer;
  $('.fdrs-home-logo').on('click',function(index){
  	var member_id = $(this).attr('member_id');
  	var member_name = $(this).attr('title');
  	layer.open({
	    type: 2, title: member_name,
	    closeBtn: 1, shadeClose: true,
	    area:['800px','500px'],
	    content: "/member/" + member_id
	  });
  });

  <?php }?>
  
  // home_btn_over
  // $('.main1 .sort a').each(function(index){
  // 	var _this = this;
  // 	$(this).mouseover(function(){ $(_this).addClass('home_btn_over'); });
  // 	$(this).mouseout(function(){$(_this).removeClass('home_btn_over');});
  // });

});
</script> 
</body>
</html>