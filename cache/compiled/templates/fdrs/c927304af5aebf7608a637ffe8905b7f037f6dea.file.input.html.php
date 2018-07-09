<?php /* Smarty version Smarty-3.0.8, created on 2018-07-06 20:17:06
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/fdrs\member/input.html" */ ?>
<?php /*%%SmartyHeaderCode:178065b3f5dc26fde28-18289306%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c927304af5aebf7608a637ffe8905b7f037f6dea' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/fdrs\\member/input.html',
      1 => 1530879424,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '178065b3f5dc26fde28-18289306',
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
body,html{margin:0;padding:0;border:0;width:100%;height:100%; overflow:hidden; }
#inputfrm1{ margin:10px auto;}
.table_default,.grid_upload{ width:98%!important; margin: 5px auto; }
</style>
<?php $_template = new Smarty_Internal_Template('../local_js.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<script src="<?php echo $_smarty_tpl->getVariable('res')->value;?>
/miniui/swfupload/swfupload.js" type="text/javascript"></script>
<script type="text/javascript">
var id = <?php echo $_smarty_tpl->getVariable('id')->value;?>
;
var APP = '<?php echo $_smarty_tpl->getVariable('controller')->value;?>
';
var data = <?php echo $_smarty_tpl->getVariable('data')->value;?>
;
var ary_types = <?php echo $_smarty_tpl->getVariable('member_types')->value;?>
;
$(document).ready(function(){ setTimeout(init,0); });
function init(){ 
	mini.parse(); 
	init_types();
	if(id > 0){
		var frm = new mini.Form('#inputfrm1');
		frm.setData(data);
	}
}

function init_types()
{
	var type_id = mini.get('type_id');
	type_id.loadList(ary_types);
}

function save()
{
	var frm = new mini.Form("inputfrm1");
	frm.validate();
	if (frm.isValid() == false) return;
	var fileupload = mini.get("fileupload1");
	
	if(fileupload.getText() == ''){
    	var o = frm.getData(true);
		showloading('正在保存...');
		$.ajax({
			url: '/?app=' + APP + '&act=save_member',
			data: o,type:'post',
			success: function (json) {
				successHandler(json,function(){
					mini.alert(json.message,'',function(action){ 
						if(json.code == 1){ close_me(); }
					});
				});
			},
			error: function (jqXHR, textStatus, errorThrown) { error_req(); }
		});
    }else{
    	var objType = mini.get('type_id').getSelectedNode();
    	var o = frm.getData(true);
    	objType.id = o.id;
    	objType.type_id = o.type_id;
    	objType.title = o.title;
    	objType.note = o.note;
    	fileupload.setPostParam(objType);
		fileupload.startUpload();
    }
}

function onUploadSuccess(e) {
    var json = mini.decode(e.serverData);
    successHandler(json,function(){
		mini.alert(json.message,'',function(action){ 
			if(json.code == 1){ close_me(); }
		});
	});
}
function onUploadError(e) {
    mini.alert("上传失败：" + e.file + ' ' + e.message);
}

function onCloseClick(e) {
	var sender = e.sender;
	sender.set({ 'value':0,'text':''});
}
</script>
</head>
<body>   
<div class="mini-fit">
	<div id="inputfrm1">
        <div class="mini-hidden" name="id" id="id"></div>
        <table border="0" class="table_default">
            <tr>
                <td width="110">单位名称：</td>
                <td><input id="title" name="title" class="mini-textbox" style="width:100%" 
                	emptyText="最长不要超过60个字符" vtype="maxLength:60"
                	required="true" errorMode="border"  /></td>
            </tr>
            <tr>
                <td>所属分类：</td>
                <td><input id="type_id" name="type_id" class="mini-treeselect" 
                	multiSelect="false" style="width:250px;" showNullItem="true"
                    showFolderCheckBox="true" showTreeIcon="false"
                    required="true" errorMode="border" popupWidth="250"
                    allowInput="true" pinyinField="tag" emptyText="支持字母筛选" />
                    <label>例如：输入 “hd” 即可以找到 “活动”</label>
                </td>
            </tr>
            <tr>
                <td>单位LOGO：</td>
                <td><div id="fileupload1" class="mini-fileupload" name="Fdata" 
				    	limitType="*.gif;*.jpg;*.png" style="width: 40%" 
					    flashUrl="/resource/miniui/swfupload/swfupload.swf"
					    uploadUrl="/?app=member_controller_fdrs&act=save_member" 
					    onuploadsuccess="onUploadSuccess" onuploaderror="onUploadError">
					</div>
                </td>
            </tr>
            <tr>
                <td>网址：</td>
                <td><input id="site_url" name="site_url" class="mini-textbox" 
                	style="width:100%" errorMode="border" 
                	emptyText="例如：www.fdrs.com" vtype="url"
                	onbuttonclick="select_content_link" /></td>
            </tr>
            <tr>
                <td>简介：</td>
                <td><textarea class="mini-textarea" name="note" 
                	style="width: 100%;height: 220px"></textarea>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="mini-toolbar bottom_bar">
    <a class="mini-button" onclick="save">保存</a>
</div>
</body>
</html>