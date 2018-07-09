<?php /* Smarty version Smarty-3.0.8, created on 2018-06-21 22:51:30
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\shop/cart.html" */ ?>
<?php /*%%SmartyHeaderCode:317625b2bbb72e1c8b7-41043061%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '07697d25f958cfc47440c6fc8cb0e4e8515677a0' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\shop/cart.html',
      1 => 1527917324,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '317625b2bbb72e1c8b7-41043061',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('head.layui.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<div class="layui-container" id="ussv_content">
	<div class="layui-row ussv-cart-view">
		<div class="layui-col-md12">
			<table id="tb_cart" lay-filter="tb_cart"></table>
		</div>
	</div>
</div>
<script type="text/html" id="photoTpl">
  <img src="{{ d.cover_photo }}" />
</script>
<script type="text/html" id="numTpl">
  <div class="ussv-cart-num">
  	<div lay-event="jian"><img src="/assets/shop/icon_jian.png" /></div>
  	<div>{{ d.num }}</div>
  	<div lay-event="jia"><img src="/assets/shop/icon_jia.png" /></div>
  </div>
</script>
<script type="text/html" id="priceTpl">
  <div class="ussv-cart-price">￥{{ d.price1 }}</div>
</script>
<script type="text/html" id="actionTpl">
  <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="del">删除</a>
</script>
<script type="text/javascript">
layui.use(['layer','table','jquery'], function(){
  var layer = layui.layer
  ,table = layui.table
  ,$ = layui.jquery;

  layer.config({ extend: 'ussv/style.css', skin: 'layer-ext-ussv' });	

  table.render({
    elem: '#tb_cart'
    //,cellMinWidth: 80
    //,height: 'full'
    ,text: { none: '购物车中暂无数据~' }
    ,url: '/cart/query' //数据接口
    ,page: false
    ,cols: [[ //表头
      {field: 'cover_photo', title: '图片', templet: '#photoTpl', align: 'center'}
      ,{field: 'name', title: '名称', align: 'center'}
      ,{field: 'price1', title: '单价', width:100, templet: '#priceTpl', align: 'center'}
      ,{field: 'num', title: '数量', width:120, templet: '#numTpl', align: 'center'} 
      ,{field: 'action', title: '#', templet: '#actionTpl', width: 80, align: 'center'}
    ]]
  });

  // 监听action
  table.on('tool(tb_cart)', function(obj){
    var data = obj.data;
    switch(obj.event){
    	case 'del':
    		layer.confirm('确定要移除出购物车吗', function(index){
		        layer.close(index);
		        var index = layer.msg('请稍后 ..', { icon: 16,shade: 0.01, time: 0 });
			    $.ajax({
					url: '/cart/remove',
					type:'post',data:{ ids:data.id },
					success: function (json) {
							layer.close(index);
							if(json.code != 1){
								layer.alert(json.message);
							}else{
								obj.del();
							}
						},
					error: function (jqXHR, textStatus, errorThrown) { 
						layer.msg('网络错误,请稍后再试', {icon: 5});
					}
				});	
		      });
    		break;
    	case 'jia':	case 'jian':
    		var index = layer.msg('请稍后 ..', { icon: 16,shade: 0.01, time: 0 });
		    $.ajax({
				url: '/cart/update',
				type:'post',data:{ id:data.id,update_type:obj.event },
				success: function (json) {
						layer.close(index);
						if(json.code != 1){
							layer.alert(json.message);
						}else{
							if(json.data <= 0){
								obj.del();
							}else{
								obj.update({ num: json.data });
							}
						}
					},
				error: function (jqXHR, textStatus, errorThrown) { 
					layer.msg('网络错误,请稍后再试', {icon: 5});
				}
			});	
    		break;
    }
    
  });

});
</script> 