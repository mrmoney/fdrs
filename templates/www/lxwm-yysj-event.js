layui.use(['layer','jquery'], function(){
    var layer = layui.layer
    ,$ = layui.jquery;
    //顶部两个按钮
    $('.ussv-lxwm').on('click',function(){ 
      	layer.open({
    	  type: 2, title: '联系我们',
    	  closeBtn: 1, shadeClose: true,
    	  area:['580px','300px'],
    	  content: "/contact",skin:'ussv-lxwm-win',
    	});
    });

    $('.ussv-yysj').on('click',function(){ 
        layer.open({
        type: 2, title: '预约试驾',
        closeBtn: 1, shadeClose: false,
        area:['580px','320px'],
        content: "/testreq/view",skin:'ussv-yysj-win',
      });
    });
});