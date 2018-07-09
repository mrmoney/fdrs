<?php /* Smarty version Smarty-3.0.8, created on 2018-07-07 09:11:19
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\member/members.html" */ ?>
<?php /*%%SmartyHeaderCode:92485b401337d68d89-66237454%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9173e9cee1df40314508ef6454d36ce50c576bc5' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\member/members.html',
      1 => 1530925876,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '92485b401337d68d89-66237454',
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
                  <a><cite>会员</cite></a>
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
                              研究会会员</h1>
      					</section>
      					<section class="met-editor clearfix">
                  <main class="news_list_page_met_28_1 met-news">
                    <div class="row">
                      <div class="col-md-12 met-news-body">
                          <div class="met-news-list">
                            <ul class="ulstyle met-pager-ajax imagesize fdrs-subject-card">
                              <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('members')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
                                <li class='border-bottom1 fdrs-m-list-nopadding'>
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                  <tr>
                                    <?php if ($_smarty_tpl->tpl_vars['item']->value['site_url']!=''){?>
                                    <td class="fdrs-m-list-logo"><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['site_url'];?>
" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['logo_path'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
"></a></td>
                                    <?php }else{ ?>
                                    <td class="fdrs-m-list-logo"><img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['logo_path'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
"></td>
                                    <?php }?>
                                    <td member_id="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
" class="fdrs-m-list-td">
                                      <h4>
                                        <i class="icon pe-angle-right"></i>
                                        <?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>

                                      </h4>
                                      <p class="des font-weight-300"><?php echo $_smarty_tpl->tpl_vars['item']->value['note'];?>
</p>
                                    </td>
                                  </tr>
                                </table>
                              </li>
                              <?php }} ?>
                            </ul>
                      </div>
                    </div>
                    </div>
                  </main>
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
layui.use(['element','layer','jquery'], function(){
  var element = layui.element;
  var layer = layui.layer,$ = layui.jquery;
  $('.fdrs-m-list-td').on('click',function(index){
    var member_id = $(this).attr('member_id');
    var member_name = $(this).attr('title');
    layer.open({
      type: 2, title: member_name,
      closeBtn: 1, shadeClose: true,
      area:['800px','500px'],
      content: "/member/" + member_id
    });
  });
});
</script> 
</body>
</html>