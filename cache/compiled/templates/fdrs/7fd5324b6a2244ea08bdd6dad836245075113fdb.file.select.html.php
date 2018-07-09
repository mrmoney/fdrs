<?php /* Smarty version Smarty-3.0.8, created on 2018-07-03 21:51:01
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/fdrs\subject/select.html" */ ?>
<?php /*%%SmartyHeaderCode:149185b3b7f456a6ca0-33176298%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7fd5324b6a2244ea08bdd6dad836245075113fdb' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/fdrs\\subject/select.html',
      1 => 1530625858,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '149185b3b7f456a6ca0-33176298',
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
var grid = null;
$(document).ready(function(){ 
    mini.parse();
    grid = mini.get("datagrid1");
    load_data();
});

//main scope -----
function onload_grid(e){  }

function onActionRenderer(e)
{
    var record = e.record,column = e.column,s = '';
    switch(column.name){
       case 'preview':
            s = '<span class="icon-search actions" title="预览" onclick="preview(' + 
                    record.id+',\''+record.topic+'\')"></span>';
            break;
    }
    return s;
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
    grid.load(o);
    grid.clearSelect();
}

var selected_content = { 'value':0,'text' :'' };
function submit_select()
{
    var row = grid.getSelected();
    if(row){
        selected_content.value = row.id;
        selected_content.text = row.topic;
    }
    closeWindow('ok');
}
</script>
</head>
<body>
<div class="mini-toolbar top_bar">
    <table style="width:100%;">
        <tr>
        <td style="width:100%;">
            <div id="frm1">
                <label>关键词：</label><input name="fieldvalue" id="fieldvalue" 
                    class="mini-textbox" emptyText="至少两字符"
                    onenter="load_data" style="width:150px;" />
                <a class="mini-button" id="btn_search" iconCls="icon-search" 
                    plain="true" onclick="load_data">筛选</a>
            </div>
        </td>
        <td style="white-space:nowrap;"></td>
        </tr>
    </table>
</div>
<div class="mini-fit">
    <div id="datagrid1" class="mini-datagrid" style="width:100%;height:100%;" 
            pageSize="20" allowAlternating="true" allowCellWrap="true"
            multiSelect="false" emptyText="没有查询到相关结果 ..." 
            allowUnselect="false" sizeList="[20,50,80,100]" 
            borderStyle="border-left:0;border-top:0" onload="onload_grid"
            url="/?app=<?php echo $_smarty_tpl->getVariable('controller')->value;?>
&act=query_contents">
        <div property="columns">
            <div type="checkcolumn"></div>
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
        </div>
    </div>
</div>
<div class="mini-toolbar bottom_bar">
    <a class="mini-button" onclick="submit_select">确认</a>
    <span class="separator"></span>
    <a class="mini-button" onclick="closeWindow('close')">取消</a>
</div>
</body>
</html>