<?php /* Smarty version Smarty-3.0.8, created on 2018-07-03 22:07:52
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\v1/index.html" */ ?>
<?php /*%%SmartyHeaderCode:169885b3b83388ebaf8-42161097%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f22e6c666bed216ae3d5a18a7607dff579df7c3f' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\v1/index.html',
      1 => 1530626869,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '169885b3b83388ebaf8-42161097',
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
<script src="http://met.evgo.me/public/ui/v2/static/js/lteie9.js"></script>
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
		<div class="item  col-xs-12 col-md-8" >
		        <div class="met-index-imgnews">
			        <div class="left-news">
				        <div class="left-img ussv-home-scroll1">
				        	<div class="layui-carousel ussv-latoRegular" id="scroll1">
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
        	<div class="item  col-xs-12 col-md-4">
                <div class="met-index-imgnews">
		            <ul class="right-news news-ul">
	            		<div class="right-img">
					        <a href="http://met.evgo.me/news/" title="金融聚焦">
					        	<img src="/images/y_g_a.jpg">
					        </a>
					    </div>
					    <li>
							<a href="http://met.evgo.me/news/news4.html" title="清北大学纳米研究所在柔性电子器件方面取得重要进展" target=_self>
								<i class="icon pe-angle-right" aria-hidden="true"></i>
                                清北大学纳米研究所在柔性电子器件方面取得重要进展			
                            </a>
						</li>
												    <li>
							<a href="http://met.evgo.me/news/news3.html" title="中国国际石墨烯创新大会召开" target=_self>
								<i class="icon pe-angle-right" aria-hidden="true"></i>
                                中国国际石墨烯创新大会召开
                            </a>
						</li>
						<li>
							<a href="http://met.evgo.me/news/news2.html" title="清北大学研究所承办第5期学科论坛" target=_self>
								<i class="icon pe-angle-right" aria-hidden="true"></i>
                                清北大学研究所承办第5期学科论坛
                            </a>
						</li>
						<li>
							<a href="http://met.evgo.me/news/news1.html" title="西北大学李副教授访问清北大学纳米研究所" target=_self>
								<i class="icon pe-angle-right" aria-hidden="true"></i>
                                西北大学李副教授访问清北大学纳米研究所
                            </a>
						</li>
					</ul>
    	    	</div>
			</div>
	</div>
		</div>
</div>

        <div class="news_list_met_27_2" m-id='28'>
	<div class="container newsbox">
		<div class="row">
		<!-- 左边新闻框 -->
		<div class="item  col-xs-12  col-lg-4">
	        <div class="met-index-news ">
	            <div class="title clearfix">
		            <h2 class="news-h">金融聚焦</h2>
		            <p class="news-desc">Financial Focus</p>
	            </div>
		        <ul class="news-list">
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
				   <a href="http://met.evgo.me/news1/" title="" target='_self'>更多</a>
		        </div>
		    </div>
	    </div>
	    <!-- 左边新闻框 -->
	    
	    <!--中间新闻框-->
	    <div class="item  col-xs-12 col-lg-4">
	        <div class="met-index-news">
		        <div class="title clearfix">
		            		            	<h2 class="news-h">研究会动态</h2>
		               <p class="news-desc">FDRS News</p>
		             
		        </div> 
		        <ul class="news-list">
		        		<li>
							<a href="http://met.evgo.me/news2/news228.html" title="纳米材料及其在涂料领域的应用" target=_self>
								<span>2018-03-28</span>
								纳米材料及其在涂料领域的应用							</a>
					    </li>
		        			        	    <li>
							<a href="http://met.evgo.me/news2/news227.html" title="纳米电镀技术的研究" target=_self>
								<span>2018-03-28</span>
								纳米电镀技术的研究							</a>
					    </li>
		        			        	    <li>
							<a href="http://met.evgo.me/news2/news226.html" title="静电纺丝技术论文" target=_self>
								<span>2018-03-28</span>
								静电纺丝技术论文							</a>
					    </li>
		        			        	    <li>
							<a href="http://met.evgo.me/news2/news225.html" title="纳米技术在军事中的应用" target=_self>
								<span>2018-03-28</span>
								纳米技术在军事中的应用							</a>
					    </li>
		        			        	    <li>
							<a href="http://met.evgo.me/news2/news224.html" title="“纳米涂层” = 新一代的不粘锅？" target=_self>
								<span>2018-03-28</span>
								“纳米涂层” = 新一代的不粘锅？							</a>
					    </li>
		        			        </ul>
		        			        <div class="more">
						 <a href="http://met.evgo.me/news2/news2_14_1.html" title="" target='_self'>更多</a>
			        </div>
			    		    </div>
	    </div>
	    <!--中间新闻框-->
	    <div class="item  col-xs-12 col-lg-4">
	        <div class="met-index-news">
		        <div class="title clearfix">
		            		            	<h2 class="news-h">会员动态</h2>
		               <p class="news-desc">Member News</p>
		             
		        </div> 
		        <ul class="news-list">
		        		<li>
							<a href="http://met.evgo.me/news2/news228.html" title="纳米材料及其在涂料领域的应用" target=_self>
								<span>2018-03-28</span>
								纳米材料及其在涂料领域的应用							</a>
					    </li>
		        			        	    <li>
							<a href="http://met.evgo.me/news2/news227.html" title="纳米电镀技术的研究" target=_self>
								<span>2018-03-28</span>
								纳米电镀技术的研究							</a>
					    </li>
		        			        	    <li>
							<a href="http://met.evgo.me/news2/news226.html" title="静电纺丝技术论文" target=_self>
								<span>2018-03-28</span>
								静电纺丝技术论文							</a>
					    </li>
		        			        	    <li>
							<a href="http://met.evgo.me/news2/news225.html" title="纳米技术在军事中的应用" target=_self>
								<span>2018-03-28</span>
								纳米技术在军事中的应用							</a>
					    </li>
		        			        	    <li>
							<a href="http://met.evgo.me/news2/news224.html" title="“纳米涂层” = 新一代的不粘锅？" target=_self>
								<span>2018-03-28</span>
								“纳米涂层” = 新一代的不粘锅？							</a>
					    </li>
		        			        </ul>
		        			        <div class="more">
						 <a href="http://met.evgo.me/news2/news2_14_1.html" title="" target='_self'>更多</a>
			        </div>
			    		    </div>
	    </div>
	</div>
	<!--container结束符-->
	</div>
</div>

        <div class="news_list_met_27_3"  m-id='31'>
	<div class="container newsbox">
	<div class="row">
		<!-- 左边新闻框 -->
		<div class="item  col-xs-12  col-lg-4">
	        <div class="met-index-news ">
	            <div class="title clearfix">
		            		               <h2 class="news-h">政策法规</h2>
		               <p class="news-desc">Policy</p>
		             
	            </div>
		        <ul class="news-list">
		        			        		<li>
							<a href="http://met.evgo.me/news2/news223.html" title="铝佐剂及其制备方法及应用" target=_self>
							<span>2018-03-28</span>
							铝佐剂及其制备方法及应用							</a>
						</li>
		        			        		<li>
							<a href="http://met.evgo.me/news2/news222.html" title="微流控管道及其制备方法" target=_self>
							<span>2018-03-28</span>
							微流控管道及其制备方法							</a>
						</li>
		        			        		<li>
							<a href="http://met.evgo.me/news2/news221.html" title="铌酸钾粉体及其制备方法" target=_self>
							<span>2018-03-28</span>
							铌酸钾粉体及其制备方法							</a>
						</li>
		        			        		<li>
							<a href="http://met.evgo.me/news2/news220.html" title="结构型吸波材料及其制作方法" target=_self>
							<span>2018-03-28</span>
							结构型吸波材料及其制作方法							</a>
						</li>
		        			        		<li>
							<a href="http://met.evgo.me/news2/news219.html" title="氮化镓纳米线及其制备方法" target=_self>
							<span>2018-03-28</span>
							氮化镓纳米线及其制备方法							</a>
						</li>
		        			        		<li>
							<a href="http://met.evgo.me/news2/news218.html" title="核酸的检测方法和试剂盒及应用" target=_self>
							<span>2018-03-28</span>
							核酸的检测方法和试剂盒及应用							</a>
						</li>
		        			        		<li>
							<a href="http://met.evgo.me/news2/news217.html" title="纳米棒及其制备方法与应用" target=_self>
							<span>2018-03-28</span>
							纳米棒及其制备方法与应用							</a>
						</li>
		        			        </ul>
		        		        	<div class="more">
					   <a href="http://met.evgo.me/news2/news2_15_1.html" title="" target='_self'>更多</a>
			        </div>
		        	        </div>
	    </div>
	    <!-- 左边新闻框 -->
	    
	    <!--中间新闻框-->
	    <div class="item  col-xs-12 col-lg-4">
	        <div class="met-index-news">
		        <div class="title clearfix">
		            		               <h2 class="news-h">活动公告</h2>
		               <p class="news-desc">Activity</p>
		             
	            </div>
		        <ul class="news-list">
	        		<li>
						<a href="http://met.evgo.me/news2/news216.html" title="纳米级氧化铝比表面积标准物质获得国家二级标准物质证书" target=_self> 
						<span>2018-03-28</span>
						纳米级氧化铝比表面积标准物质获得国家二级标准物质证书							</a>
					</li>
	        			        		<li>
						<a href="http://met.evgo.me/news2/news215.html" title="“纳米级氧化铝比表面积标准物质”获得国家一级标准物质证书" target=_self> 
						<span>2018-03-28</span>
						“纳米级氧化铝比表面积标准物质”获得国家一级标准物质证书							</a>
					</li>
	        			        		<li>
						<a href="http://met.evgo.me/news2/news214.html" title="“肿瘤捕手”技术团队荣获中科院科技成果" target=_self> 
						<span>2018-03-28</span>
						“肿瘤捕手”技术团队荣获中科院科技成果							</a>
					</li>
	        			        		<li>
						<a href="http://met.evgo.me/news2/news213.html" title="二氧化硅比表面积、孔容和孔径标准物质通过科技成果鉴定" target=_self> 
						<span>2018-03-28</span>
						二氧化硅比表面积、孔容和孔径标准物质通过科技成果鉴定							</a>
					</li>
	        			        		<li>
						<a href="http://met.evgo.me/news2/news212.html" title="中心荣获两项2017年度市科学技术奖" target=_self> 
						<span>2018-03-28</span>
						中心荣获两项2017年度市科学技术奖							</a>
					</li>
	        			        		<li>
						<a href="http://met.evgo.me/news2/news211.html" title="中心荣获两项2016年度市科学技术奖" target=_self> 
						<span>2018-03-28</span>
						中心荣获两项2016年度市科学技术奖							</a>
					</li>
	        			        		<li>
						<a href="http://met.evgo.me/news2/news210.html" title="中心荣获两项2015年度市科学技术奖" target=_self> 
						<span>2018-03-28</span>
						中心荣获两项2015年度市科学技术奖							</a>
					</li>
		        </ul>
		        	<div class="more">
					   <a href="http://met.evgo.me/news2/news2_16_1.html" title="" target='_self'>更多</a>
			        </div>
		    </div>
	    </div>
	    <!--中间新闻框-->
	    <!--产品展示区块-->
	    <div class="item col-xs-12 col-lg-4">
			<div class="met-index-product">
				<div class="container">
				    <div class="title clearfix">
				    								<h2 class="news-h">联系我们</h2>
		                    <p class="news-desc">Contact</p>
											</div>
					<div class="nav-tabs-vertical">
					    <ul class="nav nav-tabs margin-right-25 col-lg-5 col-xs-4" data-plugin="nav-tabs" role="tablist">
				    		<li role="presentation">
								<a class="     active bqy" data-toggle="tab" href="#106" role="tab" aria-expanded="true" data-id="as5" target=_self>
								<span class="newstitle">江黎明教授</span>
								</a>
							</li>
											    		<li role="presentation">
								<a class="      bqy" data-toggle="tab" href="#106" role="tab" aria-expanded="true" data-id="as6" target=_self>
								<span class="newstitle">陈祥军教授</span>
								</a>
							</li>
											    		<li role="presentation">
								<a class="      bqy" data-toggle="tab" href="#106" role="tab" aria-expanded="true" data-id="as7" target=_self>
								<span class="newstitle">周兴杰副教授</span>
								</a>
							</li>
											    		<li role="presentation">
								<a class="bqy" data-toggle="tab" href="#106" role="tab" aria-expanded="true" data-id="as4" target=_self>
								<span class="newstitle">陈巧君副教授</span>
								</a>
							</li>
						</ul>
	                    <div class="tab-content padding-vertical-15 productimg col-lg-7 col-xs-8">
                    		<div class="tab-pane active">
			                        <p></p>
								    <div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<a href="http://met.evgo.me/product/product5.html" title="江黎明教授" class="productbox">
											<img class="cover-image" src="http://met.evgo.me/upload/201803/1521797046.jpg" alt="江黎明教授"></a>
									    </div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="more" >
												<a href="http://met.evgo.me/product/product5.html" title="江黎明教授" target=_self>
												 查看详情</a>
										    </div>
									    </div>
							        </div>
		                    </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	    <!--产品展示区块-->
	    </div>
	</div>
</div>
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