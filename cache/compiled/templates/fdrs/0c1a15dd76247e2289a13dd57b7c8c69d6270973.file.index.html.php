<?php /* Smarty version Smarty-3.0.8, created on 2018-07-06 21:52:47
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/fdrs\member/index.html" */ ?>
<?php /*%%SmartyHeaderCode:145625b3f742f90e353-42431135%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0c1a15dd76247e2289a13dd57b7c8c69d6270973' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/fdrs\\member/index.html',
      1 => 1530885163,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '145625b3f742f90e353-42431135',
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

.item{
    float:left; border:solid 1px #ccc; border-radius:4px;
    width: 160px; height: 160px;
    margin-left:10px; margin-top:5px;margin-bottom: 5px; position: relative;
}

.item-inner{ padding: 5px; }

.item-image{
    width: 120px; height:80px;  margin:auto; margin-bottom:8px; 
    display:block; border-radius:4px;   
}

.item-text{
    text-align:center; font-size:12px;
    font-family:"微软雅黑"; padding-top:5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow:ellipsis; 
}

.item-checkbox{
    position: absolute; top: 10px;left: 10px;width: 20px;height: 20px;
}

.item-action{ height: 24px; line-height: 24px; text-align: right; margin-top: 5px; }
.item-action input{ margin-left: 10px; }

/*.item-edit{ top: 15px;right: 15px;width: 20px; }
.item-delete{ top: 45px;right: 15px;width: 20px; }
.item-edit,.item-delete{ position: absolute;cursor: pointer; }*/
</style>
<?php $_template = new Smarty_Internal_Template('../local_js.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<script type="text/javascript">
var APP='<?php echo $_smarty_tpl->getVariable('controller')->value;?>
';
var leftTree = null;
var ary_types1 = <?php echo $_smarty_tpl->getVariable('member_types')->value;?>
;var grid = null;
$(document).ready(function(){ 
    mini.parse();
    grid = mini.get("datagrid1");
    init_batch_menu();
    leftTree = mini.get('leftTree');
    leftTree.loadList(ary_types1);

    grid.reload();
    item_action();
});

function init_batch_menu()
{
    var batch_menus = [
                        {id: "delete_member", text: "删除", iconCls:"icon-remove"},
                        {id: "enable_member", text: "发布", status:1,act:'update_status', iconCls:"icon-upload"},
                        {id: "disable_member", text: "临时下线", status:0,act:'update_status', iconCls:"icon-download"},
                    ];
    var batchMenu = mini.get('batchMenu');
    batchMenu.loadList(batch_menus);
}

function item_action()
{
    $(grid.el).on("click", ".item-delete", function (event) {
        var record = grid.getRowByEvent(event);
        var s = record.id;
        var data = { Ids:s };
        execute_batch(data,'delete_member');
    });

    $(grid.el).on("click", ".item-edit", function (event) {
        var record = grid.getRowByEvent(event);
        var id = record.id; 
        var title = (record.title != null && record.title != '')?record.title:record.typename;
        input(id,title,record.type_id);
    });
}

function input(id,title,type_id)
{
    if(title == undefined){ title = '录入新成员'; }
    if(id == undefined){ id = 0; }
    var url = '/?app=' + APP + '&act=input&id=' + id;
    var d = {
                url: url,
                height: 450,
                width: 800,
                title: title,
                end_call:function(){ grid.reload(); }
            };
    desktop.opennew(d);
}

function itemRenderer(record, rowIndex, meta, grid) {
    meta.rowCls = "item";
    var title = record.title?record.title:record.typename;
    var html = '<div class="item-inner">'
            + '<img class="item-image" src="' + record.logo_path + '"/>'
            + '<div class="item-text">' + title + '</div>'
            + '<div class="item-action"><input type="button" value="编辑" class="item-edit" /><input type="button" value="删除" class="item-delete" /></div>'
            + '</div>';
    html += '<input type="checkbox" class="item-checkbox" value="' + record.id + '" />';
    // html += '<img class="item-edit" src="/images/edit.gif" alt="编辑" />';
    // html += '<img class="item-delete" src="/images/remove-2.gif" alt="删除" />';
    return html;
}

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

function load_data()
{
    var frm = new mini.Form("#frm1"); 
    var o = frm.getData(true);
    var objType = leftTree.getSelected();
    // console.log('load_data ..',objType);
    if(objType){ o.type_id = objType.id; }
    grid.load(o);
    grid.clearSelect();
}

function preview_photos()
{
    var objType = leftTree.getSelected();
    var title = '所有图片';
    if(objType){ title = objType.text; }
    var items = grid.getData();

    if(items.length <= 0){ mini.alert('没有可预览的Logo');return; }
    var datas = {
          "title": title, //相册标题
          "id": '123', //相册id
          "start": 0, //初始显示的图片序号，默认0
          "data": []
    };

    for(var i = 0;i < items.length; i++){
        var item = items[i];
        var data = {};
        data.alt = (item.title != '' && item.title != null)
            ?item.title:item.typename;
        data.src = item.logo_path;
        data.thumb = item.logo_path;
        datas.data.push(data);
    }

    desktop.photos(datas);
}

// 批处理模块------------------
function get_ids()
{
    var ary_ids = [];
    $(grid.el).find('.item-checkbox').each(function () {
        if($(this).prop('checked')){
            ary_ids.push($(this).attr('value'));
        }
    });
    var s = ary_ids.join(',');
    return s;
}

function onclick_batch_item(e)
{
    var node = e.item;
    switch(node.id)
    {
        case 'enable_member':
        case 'disable_member':
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

//执行货品管理中批量操作
function execute_batch(data,act)
{
    if(data.Ids == ''){ mini.alert('请先在目标图片左上角勾选要操作的对象');return; }
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
                                if(json.code == '1'){
                                    grid.clearSelect();
                                    grid.reload();
                                }else{
                                    mini.alert(json.message);
                                }
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
                        <a class="mini-button" id="btn1" iconCls="icon-add" plain="true" 
                            onclick="input">录入</a>
                        <span class="separator"></span>
                        <!-- <a class="mini-button" id="btn2" iconCls="icon-search" plain="true" 
                            onclick="preview_photos">预览</a>
                        <span class="separator"></span> -->
                        <a class="mini-button" iconCls="icon-reload" plain="true" 
                            onclick="grid.reload()">刷新</a>
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
                url="/?app=<?php echo $_smarty_tpl->getVariable('controller')->value;?>
&act=get_members"
                sizeList="[20,50,80,100]" pageSize="10"
                idField="id" allowResize="false" borderStyle="border:0"
                viewType="cardview" itemRenderer="itemRenderer" showColumns="false">
                <div property="columns"></div>
            </div>
        </div>
    </div>
</div>
</body>
</html>