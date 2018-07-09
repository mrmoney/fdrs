<?php /* Smarty version Smarty-3.0.8, created on 2018-06-22 10:17:56
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/ussv\photo/index.html" */ ?>
<?php /*%%SmartyHeaderCode:15685b2c5c54da8ea0-55296979%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2b1bff734cdabffb1b83db8600ae6b0ff8050813' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/ussv\\photo/index.html',
      1 => 1528932093,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15685b2c5c54da8ea0-55296979',
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
    margin-left:10px; margin-top:5px;margin-bottom: 5px; position: relative;
}

.item-inner{ padding: 5px; }

.item-image{
    height:180px; margin:auto; margin-bottom:8px; display:block; border-radius:4px;   
}

.item-text{
    text-align:center; font-size:12px;
    font-family:"微软雅黑"; letter-spacing:5px;
    font-weight:bold; padding-top:5px;
}

.item-checkbox{
    position: absolute; top: 10px;left: 10px;width: 20px;height: 20px;
}

.item-edit{ top: 15px;right: 15px;width: 20px; }
.item-delete{ top: 45px;right: 15px;width: 20px; }
.item-edit,.item-delete{ position: absolute;cursor: pointer; }
</style>
<?php $_template = new Smarty_Internal_Template('../local_js.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<script src="<?php echo $_smarty_tpl->getVariable('res')->value;?>
/miniui/swfupload/swfupload.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->getVariable('res')->value;?>
/miniui/swfupload/multiupload.js" type="text/javascript"></script>
<link href="<?php echo $_smarty_tpl->getVariable('res')->value;?>
/miniui/swfupload/multiupload.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
var APP='<?php echo $_smarty_tpl->getVariable('controller')->value;?>
';
var leftTree = null,grid_upload = null;
var ary_types1 = <?php echo $_smarty_tpl->getVariable('photo_types')->value;?>
;var grid = null;
$(document).ready(function(){ 
    mini.parse();
    grid = mini.get("datagrid1");
    grid_upload = mini.get('multiupload1');
    init_batch_menu();
    leftTree = mini.get('leftTree');
    leftTree.loadList(ary_types1);

    var ary_types2 = mini.clone(ary_types1);
    mini.get('type_id').loadList(ary_types2);

    grid.reload();
});

function init_batch_menu()
{
    var batch_menus = [
                        {id: "delete_photo", text: "删除", iconCls:"icon-remove"},
                        {id: "enable_photo", text: "发布", status:1,act:'update_status', iconCls:"icon-upload"},
                        {id: "disable_photo", text: "临时下线", status:0,act:'update_status', iconCls:"icon-download"},
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
        execute_batch(data,'delete_photo');
    });

    $(grid.el).on("click", ".item-edit", function (event) {
        var record = grid.getRowByEvent(event);
        var id = record.id;// console.log(record);
        var title = (record.title != null && record.title != '')?record.title:record.typename;
        input_v2(id,title,record.type_id);
    });
}

function input_v2(id,title,type_id)
{
    if(title == undefined){ title = '上传新图片'; }
    var objType = leftTree.getSelected();
    var type = !type_id?(objType?objType.id:0):type_id;
    var url = '/?app=' + APP + '&act=input_v2&type=' + type + '&id=' + id;
    var d = {
                url: url,
                height: 360,
                width: 700,
                title: title,
                end_call:function(){ grid.reload(); }
            };
    desktop.opennew(d);
}

function itemRenderer(record, rowIndex, meta, grid) {
    meta.rowCls = "item";
    var title = record.title?record.title:record.typename;
    var html = '<div class="item-inner">'
            + '<img class="item-image" src="' + record.s_path + '"/>'
            + '<div class="item-text">' + title + '</div>'
            + '</div>';
    html += '<input type="checkbox" class="item-checkbox" value="' + record.id + '" />';
    html += '<img class="item-edit" src="/images/edit.gif" alt="编辑" />';
    html += '<img class="item-delete" src="/images/remove-2.gif" alt="删除" />';
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

    if(items.length <= 0){ mini.alert('没有可预览的图片');return; }
    var datas = {
          "title": title, //相册标题
          "id": '123', //相册id
          "start": 0, //初始显示的图片序号，默认0
          "data": []
    };

    for(var i = 0;i < items.length; i++){
        var item = items[i];
        var data = {};
        data.alt = item.typename;
        // data.pid = item.type_id + '-' + item.id;
        data.src = item.b_path;
        data.thumb = item.s_path;
        datas.data.push(data);
    }

    console.log(datas,layer);

    layer.photos({ photos: datas ,anim: 5 });
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
        case 'enable_photo':
        case 'disable_photo':
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
								grid.clearSelect();
								grid.reload();
							});
                        },
                        error: function (jqXHR, textStatus, errorThrown) { error_req(); }
                    }); 
                }
        }
    );
}

// 快速上传处理模块-----------------------
function input_v1()
{
    var atEl = document.getElementById('btn1'); 
    var c = mini.get('input_c');
    c.showAtEl(atEl, { xAlign: 'left', yAlign: 'below' });
}

function before_save()
{
    var frm = new mini.Form("frm2");
    frm.validate();
    if (frm.isValid() == false) return;
    if(grid_upload.isAllUploadOver()){
        save();
    }else{
        var objType = mini.get('type_id').getSelectedNode();
        grid_upload.setPostParam(objType);
        grid_upload.startUpload();
    }
}

function save()
{
    var frm = new mini.Form("frm2");
    var o = frm.getData(true);
    var photos = grid_upload.getData();
    if(photos.length <= 0){  
        mini.alert('请上传图片,不超过5张');
        return;
    }
    o.photos = photos;

    showloading('正在保存...');
    $.ajax({
        url: '/?app=' + APP + '&act=save_photos_v1',
        data: o,type:'post',
        success: function (json) {
            successHandler(json,function(){
                mini.alert(json.message,'',function(action){ 
                    if(json.code == 1){ 
                        frm.reset();
                        grid_upload.setData(null);
                        mini.get('input_c').hide();
                        grid.reload();
                    }
                });
            });
        },
        error: function (jqXHR, textStatus, errorThrown) { error_req(); }
    });
}

function onUploadSuccess(e) {
    if(grid_upload.isAllUploadOver()){
        save();
    }
}
function onUploadError(e) {
    mini.alert("上传失败：" + e.file + ' ' + e.message);
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
                            onclick="input_v1">快速录入</a>
                        <span class="separator"></span>
                        <a class="mini-button" id="btn2" iconCls="icon-search" plain="true" 
                            onclick="preview_photos">预览</a>
                        <span class="separator"></span>
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
&act=get_photos" onload="item_action();"
                idField="id" allowResize="false" showPager="false" borderStyle="border:0"
                viewType="cardview" itemRenderer="itemRenderer" showColumns="false">
                <div property="columns"></div>
            </div>
        </div>
    </div>
</div>
<div id="input_c" class="mini-window" title="快速上传图片" 
    style="width:650px;height:350px; display:none;" 
    showMaxButton="false" showCollapseButton="false" showShadow="true"
    showToolbar="false" showFooter="true" showModal="true" 
    allowResize="false" allowDrag="true">
    <div property="footer" style="text-align:center;padding:5px;">
        <a class="mini-button" onclick="before_save">上传</a>
        <a class="mini-button" onclick="mini.get('input_c').hide()">取消</a>
    </div>
    <div id="frm2">
        <table cellpadding="0" cellspacing="0" border="0" class="table_self">
            <tr>
                <td class="td_self">所属分类：</td>
                <td class="td_self"><div id="type_id" name="type_id" class="mini-treeselect" 
                    multiSelect="false" 
                    style="width:150px;" showNullItem="true"
                    showFolderCheckBox="true" showTreeIcon="false" 
                    required="true" errorMode="border" popupWidth="180"
                    allowInput="true" pinyinField="tag" emptyText="支持字母筛选"></div>
                    <label>例如：输入 “hd” 即可以找到 “活动”</label>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="td_self">
                    <div id="multiupload1" class="uc-multiupload grid_upload" 
                            style="height: 200px;" 
                        flashurl="/resource/miniui/swfupload/swfupload.swf"
                        uploadurl="/?app=photo_controller_ussv&act=upload_photo" 
                        limitType="*.gif;*.jpg;*.png" queueLimit="5"
                        onuploaderror="onUploadError" onuploadsuccess="onUploadSuccess">
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>