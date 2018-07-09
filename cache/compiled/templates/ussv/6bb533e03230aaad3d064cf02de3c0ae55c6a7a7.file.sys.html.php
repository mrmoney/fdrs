<?php /* Smarty version Smarty-3.0.8, created on 2018-06-22 10:31:29
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/ussv\user/sys.html" */ ?>
<?php /*%%SmartyHeaderCode:114215b2c5f8171b178-17618006%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6bb533e03230aaad3d064cf02de3c0ae55c6a7a7' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/ussv\\user/sys.html',
      1 => 1528337033,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '114215b2c5f8171b178-17618006',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title><?php echo $_smarty_tpl->getVariable('site_name')->value;?>
</title>
<link href="/resource/css/mini-common.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body,html{margin:0;padding:0;border:0;width:100%;height:100%;overflow:hidden;}
</style>
<?php $_template = new Smarty_Internal_Template('../local_js.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<script type="text/javascript">
var APP='<?php echo $_smarty_tpl->getVariable('controller')->value;?>
',grid = null;
var ary_status = <?php echo $_smarty_tpl->getVariable('ary_status')->value;?>
;
$(document).ready(function(){ setTimeout(init,0); });
function init()
{
	mini.parse();
	
	//初始化批量操作下拉菜单
	var batch_menus = [
					{id: 'delete', text: "删除",status:2},
					{id: 'update_status_1', text: "启用账户",status:1,act:'update_status'},
					{id: 'update_status_0', text: "禁用账户",status:0,act:'update_status'},
					{id: 'update_status_2', text: "员工离职",status:2,act:'update_status'}
				];
	var batchMenu = mini.get('batchMenu');
	batchMenu.loadList(batch_menus);
	
	mini.get('ustatus').setValue(1);
	grid = mini.get("datagrid1");
	query_users();
}

function query_users()
{
	var frm = new mini.Form('frm1');
	var o = frm.getData();
	grid.load(o);
	grid.clearSelect();
}

//执行批量操作
function onclick_batch_item(e)
{
	var node = e.item;
	var rows = grid.getSelecteds();
	if(rows.length <= 0){ mini.alert('请选择要执行 ('+ node.text +') 操作的条目');return; }

	switch(node.id)
	{
		default:
			var data = {rows:rows,status:node.status};
			var act = typeof(node.act) != 'undefined'?node.act:node.id;
			execute_batch(data,act);
			break;	
	}
}

//执行批量操作
function execute_batch(data,act)
{
	var note_text = '您确定要执行所选操作吗';
	mini.confirm(note_text, "再次确认",
			function (action) {
				if (action == "ok") {
					showloading();
					$.ajax({
						url: '/?app=' + APP + '&act=' + act,
						data: data,type:'post',
						success: function (json) {
							successHandler(json,function(){
								mini.alert(json.message,'结果提示',function(action){ 
									if(json.code == 1){ 
										grid.reload();
										grid.clearSelect();
									}
								});
							});
						},
						error: function (jqXHR, textStatus, errorThrown) { error_req(); }
					});	
				}
		}
	);
}

//行的选择改变时执行
function onselectionchanged(e)
{
	var btn_batch = mini.get('btn_batch');
	var rows = grid.getSelecteds();
	if(rows.length > 0){
		btn_batch.enable();
	}else{
		btn_batch.disable();
	}
}

//当表格重新加载的时候
function onGridLoad(e)
{
	if(grid.getData().length <= 0)
	{
		grid.setEmptyText('没有查询到相关数据 ...');
		grid.setShowEmptyText(true);
	}
}

var obj_status = {'0':'禁用','1':'正常','2':'离职'};
//查询结束后自定义列
function resetcoloumn(e)
{
	var field = e.field,value = e.value,column = e.column;
	var row = e.record,status = row.ustatus;
	
	if (field == "ustatus") {
		e.cellHtml = obj_status[status];
	}
	
	if(status == '2'){ e.rowStyle = 'background:#EEE;color:#666'; }
	if(status == '0'){ e.rowStyle = 'background:#FFE3F7;'; }
}

function input(id,realname)
{
	var title = id > 0?'修改 (' + realname + ') 的账户属性':'新增登录账户';
	mini.open({
		url: '/?app=' + APP + '&act=input&id=' + id,
		showModal: true,allowResize:false,
		title: title,
		width: 500,height: 350,
		ondestroy: function (action) { if (action == 'ok') { grid.reload(); } }
	});	
}

function onActionRenderer(e)
{
	var record = e.record,column = e.column,s = '';
    switch(column.name){
        case 'edit':
            s = '<span class="icon-edit actions" title="修改" onclick="input(' + 
				record.Id + ',\''+record.realname+'\')"></span>';
            break;
    }
    return s;
}
</script>
</head>
<body> 
<div class="mini-toolbar top_bar no_padding">
    <table style="width:100%;">
        <tr>
        <td style="width:100%;">
        <div id="frm1">
            <label>状态：</label><input id="ustatus" name="ustatus" class="mini-combobox" style="width:100px;" popupWidth="130" textField="text" 
                valueField="id" multiSelect="true" data="ary_status" emptyText="请选择" /> , 
            <label>姓名：</label><input id="fieldvalue" name="fieldvalue" class="mini-textbox" emptyText="可模糊"
                     onenter="query_users" style="width:100px;" /> 
            <a class="mini-button" iconCls="icon-search" plain="true" onclick="query_users">查询</a>
            <a class="mini-button" iconCls="icon-add" plain="true" onclick="input">新增</a>
        </div>
        </td>
        <td style="white-space:nowrap;">
        <a class="mini-menubutton " menu="#batchMenu" plain="true" id="btn_batch" 
        	enabled="false" iconCls="icon-goto">批量操作...</a>
         <ul id="batchMenu" class="mini-menu" textField="text" idField="id" parentField="pid" 
         	onitemclick="onclick_batch_item"></ul>
        </td>
        </tr>
    </table>
</div>
<div class="mini-fit">
    <!--撑满页面-->
    <div id="datagrid1" class="mini-datagrid" style="width:100%;height:100%;"
        allowCellWrap="true" allowAlternating="true" showPager="false"
            allowResize="false" url="/?app=<?php echo $_smarty_tpl->getVariable('controller')->value;?>
&act=users"
            onload="onGridLoad" multiSelect="true" borderStyle="border-top:0"
            onselectionchanged="onselectionchanged" ondrawcell="resetcoloumn">
        <div property="columns">
            <div type="checkcolumn"></div>
            <div field="username" width="60" align="center" headerAlign="center">登录账户</div>    
            <div field="realname" width="60" align="center" headerAlign="center">姓名</div>
            <div field="tel" width="80" align="center" headerAlign="center">电话</div>
            <div field="roles" width="120" align="center" headerAlign="center">岗位角色</div>
            <div field="ustatus" width="40" align="center" headerAlign="center">状态</div>
            <div name="edit" width="40" headerAlign="center" 
            	align="center" renderer="onActionRenderer" cellStyle="padding:0;">#</div>
        </div>
    </div> 
</div>
</body>
</html>