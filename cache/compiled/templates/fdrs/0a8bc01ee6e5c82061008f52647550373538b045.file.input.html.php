<?php /* Smarty version Smarty-3.0.8, created on 2018-06-22 14:49:54
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/fdrs\cms/input.html" */ ?>
<?php /*%%SmartyHeaderCode:161095b2c9c12c6b1c2-89347677%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0a8bc01ee6e5c82061008f52647550373538b045' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/fdrs\\cms/input.html',
      1 => 1529650191,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '161095b2c9c12c6b1c2-89347677',
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
.editor_c{ margin: 5px auto;width: 98%; }
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
var id = '<?php echo $_smarty_tpl->getVariable('id')->value;?>
';
var APP = '<?php echo $_smarty_tpl->getVariable('controller')->value;?>
';
var ary_types = <?php echo $_smarty_tpl->getVariable('cms_types')->value;?>
;
var editor,grid_upload,tabs1;
$(document).ready(function(){ setTimeout(init,0); });
function init(){ 
	mini.parse(); 
	init_types();
	create_fckeditor();
	grid_upload = mini.get('multiupload1');
	// tabs1 = mini.get('tabs1');
}

function create_fckeditor()
{
	$.getScript('/resource/kindeditor/kindeditor.js', function() {
						KindEditor.basePath = '/resource/kindeditor/';
						editor = KindEditor.create('#detail',{
								uploadJson : '/?app=editor_controller_photo&act=upload',
								allowFileManager : false
							});
						if(parseInt(id) > 0){ load_data(id); }
					});
}

function init_types()
{
	var type_id = mini.get('type_id');
	type_id.loadList(ary_types);
	var init_type = <?php echo $_smarty_tpl->getVariable('type')->value;?>
;
	if(init_type > 0){ type_id.setValue(init_type); }
}

function load_data(id)
{
	showloading('正在加载 ...');
	$.ajax({
		url: '/?app=' + APP + '&act=query_content&id=' + id,
		type:'get',
		success: function (json) {
				successHandler(json,function(){
					if(json.code == 1){
						var data = json.data;
						if(data != null){
							var frm = new mini.Form("inputfrm1");
							frm.setData(data.frm);
							editor.html(data.frm.detail);
							setTimeout(function () {
								grid_upload.setData(data.photos);
							}, 500);
						}
					}else{ mini.alert(json.message); }
				});
			},
		error: function (jqXHR, textStatus, errorThrown) { error_req(); }
	});	
}

function before_save()
{
	var frm = new mini.Form("inputfrm1");
	frm.validate();
	if (frm.isValid() == false) return;
	var text = editor.html();
	if(Trim(text) == ''){  
		// var tab = tabs1.getTab(1);
		// tabs1.activeTab(tab);
		mini.alert('没有录入详细内容');
		return;
	}
	if(grid_upload.isAllUploadOver()){
    	save();
    }else{
		grid_upload.startUpload();
    }
}

function save()
{
	var frm = new mini.Form("inputfrm1");
	var text = editor.html();
	var o = frm.getData(true);
	o.detail = text;
	var photos = grid_upload.getData();
	if(photos.length <= 0){  
		// var tab = tabs1.getTab(0);
		// tabs1.activeTab(tab);
		mini.alert('请上传装备图片,不超过5张');
		return;
	}
	o.photos = photos;

	var req_data = mini.encode(o);
	showloading('正在保存...');
	$.ajax({
		url: '/?app=' + APP + '&act=save_cms',
		data: { data:req_data },type:'post',
		success: function (json) {
			successHandler(json,function(){
				mini.alert(json.message,'',function(action){ 
					if(json.code == 1){ close_me(); }
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
<div class="mini-fit">
    <div id="inputfrm1">
        <div class="mini-hidden" name="id" id="id"></div>
        <table border="0" class="table_default">
            <tr>
                <td width="80">主标题：</td>
                <td colspan="3"><input id="topic" name="topic" class="mini-textbox" required="true" errorMode="border" style="width:100%" emptyText="最长不要超过60个字符" 
                	vtype="maxLength:60" /></td>
            </tr>
            <tr>
                <td>副标题：</td>
                <td><input id="sectopic" name="sectopic" class="mini-textbox"
                	style="width:100%" emptyText="选填，最长不要超过30个字" 
                	vtype="maxLength:30" /></td>
                <td>所属分类：</td>
                <td><input id="type_id" name="type_id" class="mini-treeselect" multiSelect="false" 
                	style="width:150px;" showNullItem="true"
                    showFolderCheckBox="true" showTreeIcon="false" 
                    required="true" errorMode="border" popupWidth="180"
                    allowInput="true" pinyinField="tag" emptyText="支持字母筛选" />
                    <label>例：输入 “hd” 即可找到 “活动”</label>
                </td>
            </tr>
            <tr>
                <td>排序：</td>
                <td><div id="order_id" name="order_id" changeOnMousewheel="false" 
                		class="mini-spinner" minValue="1" maxValue="300" 
                		style="width: 80px"></div>
                	<label>数值越大，优先展示</label>
                </td>
                <td>日期：</td>
                <td><div id="publishtime" name="publishtime" 
                			class="mini-datepicker"></div>
                	<label>无时效性内容可留空</label>
                </td>
            </tr>
        </table>
        <div id="multiupload1" class="uc-multiupload grid_upload" 
				style="height: 200px;" 
	        flashurl="/resource/miniui/swfupload/swfupload.swf"
	        uploadurl="/?app=cms_controller_fdrs&act=upload_photo" 
	        limitType="*.gif;*.jpg;*.png" queueLimit="5"
	        onuploaderror="onUploadError" onuploadsuccess="onUploadSuccess">
	    </div>
    </div>

	<table border="0" cellpadding="0" cellspacing="0" class="editor_c">
        <tr>
            <td><textarea id="detail" name="detail" 
            	style="width:100%;height:410px;visibility:hidden"></textarea></td>
        </tr>
    </table>
</div>
<div class="mini-toolbar bottom_bar">
    <a class="mini-button" onclick="before_save">保存</a>
</div>
</body>
</html>