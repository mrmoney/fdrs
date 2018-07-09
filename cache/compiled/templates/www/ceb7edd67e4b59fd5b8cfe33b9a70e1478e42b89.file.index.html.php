<?php /* Smarty version Smarty-3.0.8, created on 2018-06-21 22:51:28
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/www\shop/index.html" */ ?>
<?php /*%%SmartyHeaderCode:6265b2bbb705151c2-64114847%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ceb7edd67e4b59fd5b8cfe33b9a70e1478e42b89' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/www\\shop/index.html',
      1 => 1528071696,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6265b2bbb705151c2-64114847',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('head.layui.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<div class="layui-container" id="ussv_content">
	<div class="layui-row ussv-black-bg ussv-header">
		<div class="layui-col-md3"><a href="/"><img class="ussv-top-logo" src="/images/logo-2.png" alt="<?php echo $_smarty_tpl->getVariable('site_name')->value;?>
"></a></div>
	    <div class="layui-col-md5 uusv-center">
			<ul class="layui-nav ussv-no-bg" lay-filter="">
			  <li class="layui-nav-item"><a href="/brand/index">品牌</a></li>
			  <li class="layui-nav-item"><a href="/wangzu/index">望族</a></li>
			  <li class="layui-nav-item"><a href="/jianke/index">见客</a></li>
			  <li class="layui-nav-item ussv-latoHeavy"><a href="/car/gx">GX</a></li>
			  <li class="layui-nav-item">|</li>
			  <li class="layui-nav-item ussv-latoHeavy"><a href="/car/xt">XT</a></li>
			  <li class="layui-nav-item layui-this"><a href="/shop/index">装备</a></li>
			</ul>
	    </div>
	    <div class="layui-col-md4">
	    	<button class="layui-btn ussv-lxwm ussv-rt-btn-lxwm ussv-rt-btn">联系我们</button>
	    	<button class="layui-btn ussv-yysj ussv-rt-btn-yysj ussv-rt-btn">预约试驾</button>
	    </div>
	</div>
	<div class="layui-row ussv-shop-1"></div>
	<div class="layui-row ussv-shop-2">
		<div class="layui-col-md12">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="layui-btn-container">
						<button id="btn_cart_query" class="layui-btn ussv-shop-btn-cart ussv-shop-btn"><i class="layui-icon">&#xe657;</i>购物车(<span id="num_in_cart"><?php echo $_smarty_tpl->getVariable('num_in_cart')->value;?>
</span>)</button>
		    			<button id="btn_order_query" class="layui-btn ussv-shop-btn-query ussv-shop-btn">订单查询</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="layui-row ussv-shop-3">
		<div class="layui-col-md12">
			<table cellpadding="0" cellspacing="0" border="0" class="ussv-shop-3-tb">
				<tr>
					<td>
						<ul>
							<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('datas')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
							<li>
								<div class="ussv-detail-link ussv-prod-img-cover" prod-id="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['photo_path'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
" class="ussv-prod-img"><img src="/assets/shop/Artboard_63.png" class="ussv-prod-zoom" /></div>
								<table cellpadding="0" cellspacing="0" border="0">
								    <tr>
								        <td class="ussv-prod-name ussv-detail-link" prod-id="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
								        <td rowspan="2" class="ussv-text-right"><button class="layui-btn ussv-shop-btn-buy" prod-id="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">购买</button></td>
								  </tr>
								      <tr>
								        <td class="ussv-prod-price">￥<?php echo $_smarty_tpl->tpl_vars['item']->value['price'];?>
</td>
								      </tr>
								</table>
							</li>
							<?php }} ?>
						</ul>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
var layer = null,$ = null;
layui.use(['layer','element','jquery'], function(){
  layer = layui.layer,$ = layui.jquery;
  var element = layui.element;
  layer.config({ extend: 'ussv/style.css', skin: 'layer-ext-ussv' });	

  // 绑定查看详情
  $('.ussv-detail-link').on('click',function(){
  	var id = $(this).attr('prod-id');
  	layer.open({
	        type: 2, title: false,//$(this).text(),
	        closeBtn: 0, shadeClose: true,scrollbar: false,
	        area:['800px','500px'],
	        content: "/product/item/" + id
	  });
  });

  // 绑定购买按钮
  $('.ussv-shop-btn-buy').on('click',function(){
  	var id = $(this).attr('prod-id');
  	var index = layer.msg('请稍后 ..', { icon: 16,shade: 0.01, time: 0 });
    $.ajax({
		url: '/cart/add',
		type:'post',data:{ ids:id },
		success: function (json) {
				layer.close(index);
				layer.msg(json.message);
				if(json.code == 1){
					$('#num_in_cart').text(json.data);
				}
			},
		error: function (jqXHR, textStatus, errorThrown) { 
			layer.msg('网络错误,请稍后再试', {icon: 5});
		}
	});	
  });

  // 绑定订单查询
  $('#btn_order_query').on('click',function(){
  		// 先查询有没有验证过手机
  		var index = layer.msg('请稍后 ..', { icon: 16,shade: 0.01, time: 0 });
	    $.ajax({
			url: '/my/order/check', type:'get',
			success: function (json) {
					layer.close(index);
					var data = json.data;
					var options = {
							        type: 2, title: data.title,
							        closeBtn: 1, shadeClose: false,
							        area:data.area,scrollbar: false,
							        content: data.url
							    };
					if(data.btn){
						options.btn = ['下一步'];
						options. yes = function(index, layero){
							var iframeWin = window[layero.find('iframe')[0]['name']];
			        		iframeWin.verify_code();
							return false;
						}
					}
					layer.open(options);
				},
			error: function (jqXHR, textStatus, errorThrown) { 
				layer.msg('网络错误,请稍后再试', {icon: 5});
			}
		});	
  		
  });

  // 绑定购物车点击事件
  $('#btn_cart_query').on('click',function(){
  	view_cart();
  });

  function view_cart(){
	  	layer.open({
	        type: 2, title: '查看购物车',
	        closeBtn: 1, shadeClose: false,scrollbar: false,
	        area:['680px','500px'],
	        content: "/cart/view",
	        btn: ['去结算', '继续购物'],
	        yes: function(index, layero){
			    //按钮【按钮一】的回调
				layer.close(index);
				submit_order_1();
			},
			btn2: function(index, layero){
				layer.close(index);
				return false;
			}
	      });
  	}

  	function submit_order_1(){
  		layer.open({
			type: 2, title: '提交订单 - 验证手机',
	        closeBtn: 0, shadeClose: false,scrollbar: false,
	        area:['600px','280px'],
	        content: "/order/new/step/1",
	        btn: ['上一步', '下一步'],
	        yes: function(index, layero){
				layer.close(index);
				view_cart();
			},
			btn2: function(index, layero){
				var iframeWin = window[layero.find('iframe')[0]['name']];
        		iframeWin.verify_code();
				return false;
			}
		});
  	}
});

// 填写收货信息
function submit_order_2(){
	layer.open({
		type: 2, title: '提交订单 - 填写收货信息',
	    closeBtn: 0, shadeClose: false,scrollbar: false,
	    area:['600px','450px'],
	    content: "/order/new/step/2",
	    btn: ['确认提交', '放弃'],
	    yes: function(index, layero){
			//layer.close(index);
			var iframeWin = window[layero.find('iframe')[0]['name']];
        	iframeWin.save_order();
		},
		btn2: function(index1, layero){
			layer.confirm('您确定要放弃提交本次订单吗?',
				{ btn: ['继续提交','放弃吧'] },
				function(index2){layer.close(index2);}, 
				function(){ layer.close(index1); }
			); 
			return false;
		}
	});
}

function pay(){
	layer.open({
		type: 2, title: '订单付款',
	    closeBtn: 0, shadeClose: false,scrollbar: false,
	    area:['600px','450px'],
	    content: "/order/pay",
	    btn: ['付款完成', '放弃'],
	    yes: function(index, layero){
			open_myorder();
			layer.close(index);
		},
		btn2: function(index1, layero){
			layer.confirm('您确定要放弃付款吗?',
				{ btn: ['继续付款','放弃吧'] },
				function(index2){layer.close(index2);}, 
				function(){ layer.close(index1); }
			); 
			return false;
		}
	});
}

function open_myorder()
{
	$("#btn_order_query").trigger("click");
}
</script> 
<?php $_template = new Smarty_Internal_Template('foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>