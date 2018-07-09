<?php /* Smarty version Smarty-3.0.8, created on 2018-07-06 22:14:10
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\testreq.html" */ ?>
<?php /*%%SmartyHeaderCode:82375b3f7932b59009-50884188%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '70d68228b1fe7b28fbc0448b3cb66bdd9cd66971' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\testreq.html',
      1 => 1528334684,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '82375b3f7932b59009-50884188',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<title><?php echo $_smarty_tpl->getVariable('site_name')->value;?>
</title>
<link href="/resource/layui/css/layui.css" rel="stylesheet" media="all" />
<link href="/resource/css/ussv.layui.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/layui/layui-2.3.min.js"></script>
</head>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="90%" 
		align="center" style="margin:30px;">
	<tr>
		<td>
			<form class="layui-form" action="">
			  <div class="layui-form-item">
			  	<label class="layui-form-label">您的电话</label>
    			<div class="layui-input-block">
			      <input type="text" name="phone" required lay-verify="required|phone|number" 
			      	placeholder="请输入您的手机号" autocomplete="off" class="layui-input">
			  	</div>
			  </div>
			  <div class="layui-form-item">
			  	<label class="layui-form-label">您的姓名</label>
    			<div class="layui-input-block">
			      <input type="text" name="realname" required  lay-verify="required" placeholder="请输入您的姓名" autocomplete="off" class="layui-input">
			  	</div>
			  </div>
			  <div class="layui-form-item">
			  		<label class="layui-form-label">试驾地点</label>
	    			<div class="layui-input-block">
				      <input type="text" name="user_addr" required  lay-verify="required" placeholder="请输入您所在地(城市)" autocomplete="off" class="layui-input">
				  </div>
			  </div>
			  <div class="layui-form-item">
			  	<div class="layui-input-block">
				      <button class="layui-btn layui-btn-warm layui-btn-fluid" lay-submit lay-filter="frmTry">立即预约</button>
				  </div>
			  </div>
			</form>
		</td>
	</tr>
</table>
<script type="text/javascript">

layui.use(['form','jquery','layer'], function(){
  var form = layui.form,$ = layui.jquery, layer = layui.layer;
  layer.config({ extend: 'ussv/style.css', skin: 'layer-ext-ussv' });	
  //监听提交
  form.on('submit(frmTry)', function(data){
    var index = layer.msg('请稍后 ..', { icon: 16,shade: 0.01, time: 0 });
    $.ajax({
		url: '/testreq/save',
		type:'post',data:data.field,
		success: function (json) {
				layer.close(index);
				if(json.code == 1){
					layer.alert(json.message, function(index){
						var o = parent.layer.getFrameIndex(window.name);
						parent.layer.close(o)
					}); 
				}else{ layer.alert(json.message); }
			},
		error: function (jqXHR, textStatus, errorThrown) { 
			layer.msg('网络错误,请稍后再试', {icon: 5});
		}
	});	
    return false;
  });
});
</script>
</body>
</html>