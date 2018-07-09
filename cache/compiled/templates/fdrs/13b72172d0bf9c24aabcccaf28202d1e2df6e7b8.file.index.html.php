<?php /* Smarty version Smarty-3.0.8, created on 2018-06-28 13:55:56
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/fdrs\config/index.html" */ ?>
<?php /*%%SmartyHeaderCode:54365b34786c2d1547-12809626%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '13b72172d0bf9c24aabcccaf28202d1e2df6e7b8' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/fdrs\\config/index.html',
      1 => 1530165353,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '54365b34786c2d1547-12809626',
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
.editor_c{ margin: 5px auto;width: 98%; }
</style>
<?php $_template = new Smarty_Internal_Template('../local_js.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<script type="text/javascript">
var APP='<?php echo $_smarty_tpl->getVariable('controller')->value;?>
';
var leftTree = null,editor = null,last_type_id = null;
var ary_types1 = <?php echo $_smarty_tpl->getVariable('config_types')->value;?>
;
$(document).ready(function(){ 
    mini.parse();
    leftTree = mini.get('leftTree');
    leftTree.loadList(ary_types1);
    create_fckeditor();
    // load_data();
});

function create_fckeditor()
{
    $.getScript('/resource/kindeditor/kindeditor.js', function() {
                        KindEditor.basePath = '/resource/kindeditor/';
                        editor = KindEditor.create('#detail',{
                                uploadJson : '/?app=editor_controller_photo&act=upload',
                                allowFileManager : false
                            });
                        load_data();
                    });
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
    if(objType){ 
        if(last_type_id != null && last_type_id == objType.id){ return; }
        last_type_id = objType.id;
        o.type_id = objType.id;
        showloading();
        $.ajax({
            url: '/?app=' + APP + '&act=get_config',
            data: o,type:'post',
            success: function (json) {
                successHandler(json,function(){
                    if(json.code == 1){
                        var content = json.data!=null?json.data.detail:'';
                        editor.html(content);
                    }
                });
            },
            error: function (jqXHR, textStatus, errorThrown) { error_req(); }
        });
    }
}

function save()
{
    var frm = new mini.Form("frm1");
    var o = frm.getData(true);

    var objType = leftTree.getSelected();
    if(!objType){ 
        mini.alert('请在左侧选择当前内容所在目录');
        return;
    }
    o.type_id = objType.id;

    var text = editor.html();
    o.detail = text;
    
    // var photos = grid_upload.getData();
    // o.photos = photos;

    var req_data = mini.encode(o);
    showloading('正在保存...');
    $.ajax({
        url: '/?app=' + APP + '&act=save_config',
        data: { data:req_data },type:'post',
        success: function (json) {
            successHandler(json,function(){
                mini.alert(json.message,'',function(action){ });
            });
        },
        error: function (jqXHR, textStatus, errorThrown) { error_req(); }
    });
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
        <div class="mini-fit">
            <table border="0" cellpadding="0" cellspacing="0" class="editor_c">
                <tr>
                    <td><textarea id="detail" name="detail" 
                        style="width:100%;height:580px;visibility:hidden"></textarea></td>
                </tr>
            </table>
        </div>
        <div class="mini-toolbar bottom_bar">
            <table style="width:100%;">
                <tr>
                <td style="width:100%;">
                    <div id="frm1">
                        <a class="mini-button" id="btn_new" onclick="save">保存</a>
                    </div>
                </td>
                <td style="white-space:nowrap;"></td>
                </tr>
            </table>
        </div>
    </div>
</div>
</body>
</html>