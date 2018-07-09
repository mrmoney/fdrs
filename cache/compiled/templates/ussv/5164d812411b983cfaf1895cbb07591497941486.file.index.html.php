<?php /* Smarty version Smarty-3.0.8, created on 2018-06-22 10:17:40
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/ussv\cms/index.html" */ ?>
<?php /*%%SmartyHeaderCode:68915b2c5c4405d2c4-87112091%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5164d812411b983cfaf1895cbb07591497941486' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/ussv\\cms/index.html',
      1 => 1528809597,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '68915b2c5c4405d2c4-87112091',
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
var leftTree = null;
var ary_types1 = <?php echo $_smarty_tpl->getVariable('cms_types')->value;?>
;var grid = null;
$(document).ready(function(){ 
    mini.parse();
    grid = mini.get("datagrid1");
    init_batch_menu();
    leftTree = mini.get('leftTree');
    leftTree.loadList(ary_types1);
    var ary_types2 = mini.clone(ary_types1);
    mini.get('tree1').loadList(ary_types2);
    grid.reload();
});

function on_select_tag(e)
{
    var node = e.node;
    var isLeaf = e.isLeaf;
    if (isLeaf){ load_data(); }
}

function onBeforeExpand(e) {
    var tree = e.sender;
    var nowNode = e.node;
    var level = tree.getLevel(nowNode);

    var root = tree.getRootNode();
    tree.cascadeChild(root, function (node) {
        if (tree.isExpandedNode(node)) {
            var level2 = tree.getLevel(node);
            if (node != nowNode && !tree.isAncestor(node, nowNode) && level == level2) {
                tree.collapseNode(node, true);
            }
        }
    });
}

//main scope -----
function onload_grid(e){ /*leftTree.clearSelect();*/ }

function onActionRenderer(e)
{
    var record = e.record,column = e.column,s = '';
    switch(column.name){
        case 'edit':
            s = '<span class="icon-edit actions" title="修改" onclick="input(' + 
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
                        {id: "disable_cms", text: "临时下线", status:0,act:'update_status', iconCls:"icon-download"},
                        {id: "reset_type", text: "转移分类", iconCls:"icon-reload"}
                    ];
    var batchMenu = mini.get('batchMenu');
    batchMenu.loadList(batch_menus);
}

function input(id,title)
{
    if(title == undefined){ title = '录入新内容'; }
    var objType = leftTree.getSelected();
    var type = objType?objType.id:0;
    var url = '/?app=' + APP + '&act=input&type=' + type + '&id=' + id;
    var d = {
                url: url,
                height: 550,
                width: 900,
                title: title,
                end_call:function(){ grid.reload(); }
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
                height: 550,
                width: 900,
                title: title
            };
    desktop.opennew(d);
}

function load_data()
{
    var frm = new mini.Form("#frm1"); 
    var o = frm.getData(true);
    var objType = leftTree.getSelected();
    if(objType){ o.type_id = objType.id; }
    grid.load(o);
    grid.clearSelect();
}

function get_ids()
{
    var rows = grid.getSelecteds();
    var s = '';
    for (var i = 0, l = rows.length; i < l; i++)
    {
        var row = rows[i];
        s += row.id;
        if (i != l - 1) s += ',';
    }

    return s;
}

function onclick_batch_item(e)
{
    var node = e.item;
    var rows = grid.getSelecteds();
    if(rows.length <= 0){ 
        mini.alert('请选择要执行 ('+ node.text +') 操作的数据');
        return;
    }

    switch(node.id)
    {
        case 'reset_type':
            var atEl = document.getElementById('menubutton'); 
            var c = mini.get('newtype_c');
            c.showAtEl(atEl, { xAlign: 'right', yAlign: 'below' });
            break;
        case 'enable_cms':
        case 'disable_cms':
            var s = get_ids();
            var data = { Ids:s,status:node.status };
            execute_batch(data,'update_enabled');
            break;
        default:
            var s = get_ids();
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
    var rows = grid.getSelecteds();
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
								grid.clearSelect();
								grid.reload();
								cancel_updatetype();
							});
                        },
                        error: function (jqXHR, textStatus, errorThrown) { error_req(); }
                    }); 
                }
        }
    );
}
</script>
</head>
<body>
<div class="mini-splitter" style="width:100%;height:100%;" borderStyle="border:0">
    <div size="160" showCollapseButton="false">
        <div class="mini-fit">
            <ul id="leftTree" class="mini-tree" style="width:100%;"
                showTreeIcon="true" resultAsTree="false" checkRecursive="true"
                 onnodeclick="on_select_tag" onbeforeexpand="onBeforeExpand">
            </ul>
        </div>
    </div>
    <div showCollapseButton="false">
        <div class="mini-toolbar top_bar">
            <table style="width:100%;">
                <tr>
                <td style="width:100%;">
                    <div id="frm1">
                        <label>关键词：</label><input name="fieldvalue" id="fieldvalue" class="mini-textbox" emptyText="至少两字符"
                            onenter="load_data" style="width:150px;" />
                        <a class="mini-button" id="btn_search" iconCls="icon-search" plain="true" onclick="load_data">筛选</a>
                        <a class="mini-button" id="btn_new" iconCls="icon-add" plain="true" onclick="input(0)">录入</a>
                    </div>
                </td>
                <td style="white-space:nowrap;">
                    <a class="mini-menubutton " menu="#batchMenu" plain="true" id="menubutton" iconCls="icon-goto">批量操作...</a>
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
&act=query_contents">
                <div property="columns">
                    <div type="checkcolumn" ></div>
                    <div field="publishtime" dataType="date" dateFormat="yyyy-MM-dd" 
                        width="70" headerAlign="center" align="center">发布日期</div>
                    <div field="topic" width="180" headerAlign="center">通告标题</div>
                    <div field="typename" width="85" headerAlign="center" 
                        align="center">所在分类</div>                                    
                    <div field="publisher" width="50" headerAlign="center" 
                        align="center">发布人</div>                
                    <div type="checkboxcolumn" field="enabled" width="30" 
                        headerAlign="center" align="center">显示</div>
                    <div name="preview" width="40" headerAlign="center" 
                        align="center" renderer="onActionRenderer" 
                        cellStyle="padding:0;">预览</div>
                    <div name="edit" width="40" headerAlign="center" 
                        align="center" renderer="onActionRenderer" 
                        cellStyle="padding:0;">编辑</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="newtype_c" class="mini-window" title="请选择目标分类" 
    style="width:350px;height:300px; display:none;" 
    showMaxButton="false" showCollapseButton="false" showShadow="true"
    showToolbar="false" showFooter="true" showModal="true" 
    allowResize="false" allowDrag="true">
    <div property="footer" style="text-align:center;padding:5px;">
        <input class="mini-hidden" name="ids" id="ids" />
        <a class="mini-button" onclick="moveto_newtype">保存</a>
        <a class="mini-button" onclick="cancel_updatetype">取消</a>
    </div>
    <div id="frm_newtype">
        <ul id="tree1" class="mini-tree" style="width:300px;padding:5px;" 
          resultAsTree="false" showTreeIcon="true" expandOnNodeClick="true"
          showCheckBox="true" checkRecursive="false" allowSelect="false" 
          enableHotTrack="false" showFolderCheckBox="false" 
          onbeforenodecheck="cancel_selected_newtype" />
    </div>
</div>
</body>
</html>