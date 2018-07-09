<?php /* Smarty version Smarty-3.0.8, created on 2018-06-28 22:12:24
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\head.html" */ ?>
<?php /*%%SmartyHeaderCode:9995b34ecc837c346-16908945%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1524f4d7047efa96c44ef7a23cf2b98ff3098a24' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\head.html',
      1 => 1530195139,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9995b34ecc837c346-16908945',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<header class="head_nav_met_27_1 navbar-fixed-top" m-id='39' m-type="head_nav">
<div class="container top-box">
		<div class="row">
			<div class="top-header">
				<div class="logo-box">
				    <a href="/" class="met-logo" title="<?php echo $_smarty_tpl->getVariable('site_name')->value;?>
">
				        <div class="vertical-align-middle">
					        <img src="/images/logo-500-62.png" alt="<?php echo $_smarty_tpl->getVariable('site_name')->value;?>
"/>
					    </div>
				    </a>
				</div>
				<div class="pull-md-right hidden-sm-down">
					<ul class="met-langlist pull-md-left m-b-0"></ul>
				    <div class="met-search-body pull-md-left">
				    <form method='get' class="page-search-form" role="search">
				        <div class="input-search">
				            <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
				            <input type="text" class="form-control" name="searchword" 
				                placeholder="搜索" data-fv-notempty = "true" />
				        </div>
				    </form>
				</div>
			</div>
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