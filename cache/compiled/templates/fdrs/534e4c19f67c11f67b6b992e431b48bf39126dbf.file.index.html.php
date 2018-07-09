<?php /* Smarty version Smarty-3.0.8, created on 2018-07-03 21:55:36
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/fdrs\subject/index.html" */ ?>
<?php /*%%SmartyHeaderCode:1935b3b8058e6e5d6-25043616%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '534e4c19f67c11f67b6b992e431b48bf39126dbf' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/fdrs\\subject/index.html',
      1 => 1530626109,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1935b3b8058e6e5d6-25043616',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $_smarty_tpl->getVariable('site_name')->value;?>
</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link href="/resource/css/mini-common.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body{margin:0;padding:0;border:0;width:100%;height:100%;overflow:hidden;}
</style>
<?php $_template = new Smarty_Internal_Template('../local_js.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<script type="text/javascript">
var APP='<?php echo $_smarty_tpl->getVariable('controller')->value;?>
';
var grid1 = null;
var grid2 = null,grid2_frm = null;
$(document).ready(function(){ 
    mini.parse();
    grid1 = mini.get("datagrid1");

    grid2 = mini.get("datagrid2");
    grid2_frm = document.getElementById("grid2_frm");

    init_batch_menu();
    load_data();
});

function onShowRowDetail(e) {
    var row = e.record;
    
    grid2.setData(null);
    var td = grid1.getRowDetailCellEl(row);
    td.appendChild(grid2_frm);
    grid2_frm.style.display = "block";
    grid1.clearSelect();

    grid2.load({ type_id: row.id });
}

//main scope -----
function onload_grid(e){  }

function onActionRenderer(e)
{
    var record = e.record,column = e.column,s = '';
    switch(column.name){
        case 'edit_1':
            s = '<span class="icon-edit actions" title="修改" onclick="input_subject(' + 
                    record.id+',\''+record.topic+'\')"></span>';
            break;
        case 'edit_2':
            s = '<span class="icon-edit actions" title="修改" onclick="input_item(' + 
                    record.id+',\''+record.topic+'\')"></span>';
            break;
        case 'preview':
            s = '<span class="icon-search actions" title="预览" onclick="preview(' + 
                    record.id+',\''+record.topic+'\')"></span>';
            break;
    }
    return s;
}

function init_batch_menu()
{
    var batch_menus = [
                        {id: "delete_cms", text: "删除", iconCls:"icon-remove"},
                        {id: "enable_cms", text: "发布", status:1,act:'update_status', iconCls:"icon-upload"},
                        {id: "disable_cms", text: "临时下线", status:0,act:'update_status', iconCls:"icon-download"}
                    ];
    var batchMenu = mini.get('batchMenu');
    batchMenu.loadList(batch_menus);
}

function input_subject(id,title)
{
    if(title == undefined){ title = '录入新课题'; }
    var url = '/?app=' + APP + '&act=input_subject&id=' + id;
    var d = {
                url: url,
                height: 565,
                width: 900,
                title: title,
                end_call:function(){ grid1.reload(); }
            };
    desktop.opennew(d);
}

function input_item(id,title)
{
    if(title == undefined){ title = '录入属于某课题的内容'; }
    var url = '/?app=' + APP + '&act=input_item&id=' + id;
    var d = {
                url: url,
                height: 565,
                width: 900,
                title: title,
                end_call:function(){ grid2.reload(); }
            };
    desktop.opennew(d);
}

//预览
function preview(id,title)
{
    if(title == undefined){ return; }
    var url = '/?app=' + APP + '&act=preview&id=' + id;
    var d = {
                url: url,
                height: 565,
                width: 900,
                title: title,
                end_call:function(){ }
            };
    desktop.opennew(d);
}

function load_data()
{
    var frm = new mini.Form("#frm1"); 
    var o = frm.getData(true);
    o.type_id = 1;
    grid1.load(o);
    grid1.clearSelect();
}

function get_ids()
{
    var ids = [],rows = [],s = '';
    rows = grid1.getSelecteds();
    for (var i = 0, l = rows.length; i < l; i++)
    {
        var row = rows[i];
        ids.push(row.id);
    }

    rows = grid2.getSelecteds();
    for (var i = 0, l = rows.length; i < l; i++)
    {
        var row = rows[i];
        ids.push(row.id);
    }

    return s = ids.join(',');
}

function onclick_batch_item(e)
{
    var node = e.item;
    // var rows = grid1.getSelecteds();
    var s = get_ids();
    if(s == ''){ 
        mini.alert('请选择要执行 ('+ node.text +') 操作的数据');
        return;
    }

    switch(node.id)
    {
        case 'enable_cms':
        case 'disable_cms':
            // var s = get_ids();
            var data = { Ids:s,status:node.status };
            execute_batch(data,'update_enabled');
            break;
        default:
            // var s = get_ids();
            var data = { Ids:s };
            execute_batch(data,node.id);
            break;  
    }
}

//取消所选择的新分类
function cancel_selected_newtype()
{
    var tree = mini.get("tree1");
    var nodes = tree.getAllChildNodes(tree.getRootNode());
    tree.uncheckNodes(nodes);
}

//取消转移分类
function cancel_updatetype(){
    cancel_selected_newtype();
    try{ mini.get('newtype_c').hide(); }catch(err){}
}

//转移所在分类
function moveto_newtype()
{
    var rows = grid1.getSelecteds();
    var s = get_ids();
    
    if(s == ''){ mini.alert('请选择要转移分类的条目');return; }
    var newtype = mini.get("tree1").getValue();
    if(newtype == ''){ mini.alert('请选择目标分类');return; }
    var data = {};data.type_id = newtype;data.Ids = s;
    execute_batch(data,'reset_type');
}

//执行货品管理中批量操作
function execute_batch(data,act)
{
    var note_text = '您确定要执行所选操作吗';
    mini.confirm(note_text, "再次确认",
            function (action) {
                if (action == "ok") {
                    showloading('正在执行...');
                    $.ajax({
                        url: '/?app=' + APP + '&act=' + act,
                        data: data,type:'post',
                        success: function (json) {
                            successHandler(json,function(){
                                if(grid1.getSelecteds().length > 0){
                                    grid1.clearSelect();
                                    grid1.reload();
                                }else if(grid2.getSelecteds().length > 0){
                                    grid2.clearSelect();
                                    grid2.reload();
    								cancel_updatetype();
                                }
							});
                        },
                        error: function (jqXHR, textStatus, errorThrown) { error_req(); }
                    }); 
                }
        }
    );
}

function on_select_grid1(e)
{
    var grid = e.sender;
    var rows = grid.getSelecteds();
    if(rows.length > 0){ grid2.clearSelect(); }
}

function on_select_grid2(e)
{
    var grid = e.sender;
    var rows = grid.getSelecteds();
    if(rows.length > 0){ grid1.clearSelect(); }
}
</script>
</head>
<body>
<div class="mini-toolbar top_bar">
    <table style="width:100%;">
        <tr>
        <td style="width:100%;">
            <div id="frm1">
                <label>关键词：</label><input name="fieldvalue" id="fieldvalue" class="mini-textbox" emptyText="至少两字符"
                    onenter="load_data" style="width:150px;" />
                <a class="mini-button" id="btn_search" iconCls="icon-search" 
                    plain="true" onclick="load_data">筛选</a>
                <span class="separator"></span>
                <a class="mini-button" id="btn_new" iconCls="icon-add" 
                    plain="true" onclick="input_subject(0)">录入课题</a>
                <span class="separator"></span>
                <a class="mini-button" id="btn_new" iconCls="icon-add" 
                    plain="true" onclick="input_item(0)">录入内容</a>
            </div>
        </td>
        <td style="white-space:nowrap;">
            <a class="mini-menubutton " menu="#batchMenu" plain="true" 
                id="menubutton" iconCls="icon-goto">批量操作...</a>
            <ul id="batchMenu" class="mini-menu" onitemclick="onclick_batch_item"></ul>
        </td>
        </tr>
    </table>
</div>
<div class="mini-fit">
    <div id="datagrid1" class="mini-datagrid" style="width:100%;height:100%;" 
            pageSize="20" allowAlternating="true" allowCellWrap="true"
            multiSelect="true" emptyText="没有查询到相关结果 ..." 
            allowUnselect="false" sizeList="[20,50,80,100]" 
            borderStyle="border-left:0;border-top:0" onload="onload_grid"
            url="/?app=<?php echo $_smarty_tpl->getVariable('controller')->value;?>
&act=query_contents"
            idField="id" onshowrowdetail="onShowRowDetail"
            onselectionchanged="on_select_grid1">
        <div property="columns">
            <div type="checkcolumn"></div>
            <div type="expandcolumn" >#</div>
            <div field="publishtime" dataType="date" dateFormat="yyyy-MM-dd" 
                width="70" headerAlign="center" align="center">录入日期</div>
            <div field="topic" width="180" headerAlign="center">研究课题名称</div>
            <div field="publisher" width="50" headerAlign="center" 
                align="center">发布人</div>                
            <div type="checkboxcolumn" field="enabled" width="30" 
                headerAlign="center" align="center">显示</div>
            <div name="preview" width="40" headerAlign="center" 
                align="center" renderer="onActionRenderer" 
                cellStyle="padding:0;">预览</div>
            <div name="edit_1" width="40" headerAlign="center" 
                align="center" renderer="onActionRenderer" 
                cellStyle="padding:0;">编辑</div>
        </div>
    </div>
</div>

<div id="grid2_frm" style="display:none;">
    <div id="datagrid2" class="mini-datagrid" style="width:100%;height:240px;" 
        pageSize="20" allowAlternating="true" allowCellWrap="true"
            multiSelect="true" emptyText="没有查询到相关结果 ..." 
            allowUnselect="false" sizeList="[20,50,80,100]"
            onselectionchanged="on_select_grid2" 
        url="/?app=<?php echo $_smarty_tpl->getVariable('controller')->value;?>
&act=query_contents">
        <div property="columns">
            <div type="checkcolumn"></div>
            <div field="publishtime" dataType="date" dateFormat="yyyy-MM-dd" 
                width="70" headerAlign="center" align="center">录入日期</div>
            <div field="topic" width="180" headerAlign="center">文章标题</div>
            <div field="publisher" width="50" headerAlign="center" 
                align="center">发布人</div>                
            <div type="checkboxcolumn" field="enabled" width="30" 
                headerAlign="center" align="center">显示</div>
            <div name="preview" width="40" headerAlign="center" 
                align="center" renderer="onActionRenderer" 
                cellStyle="padding:0;">预览</div>
            <div name="edit_2" width="40" headerAlign="center" 
                align="center" renderer="onActionRenderer" 
                cellStyle="padding:0;">编辑</div>               
        </div>
    </div>    
</div>
</body>
</html>