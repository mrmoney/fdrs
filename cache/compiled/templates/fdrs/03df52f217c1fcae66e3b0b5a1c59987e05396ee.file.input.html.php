<?php /* Smarty version Smarty-3.0.8, created on 2018-07-03 22:18:47
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/fdrs\photo/input.html" */ ?>
<?php /*%%SmartyHeaderCode:279965b3b85c75ac419-49784720%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '03df52f217c1fcae66e3b0b5a1c59987e05396ee' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/fdrs\\photo/input.html',
      1 => 1530626678,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '279965b3b85c75ac419-49784720',
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
.note_tips{ margin-left: 128px; line-height: 24px; }
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
var ary_types = <?php echo $_smarty_tpl->getVariable('photo_types')->value;?>
;
$(document).ready(function(){ setTimeout(init,0); });
function init(){ 
	mini.parse(); 
	init_types();
	if(id > 0){
		var frm = new mini.Form('#inputfrm1');
		frm.setData(data);
		if(data.content_id > 0){
			set_content_id(data.content);
		}else if(data.subject_id > 0){
			set_subject_id(data.content);
		}
	}
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
		url: '/?app=' + APP + '&act=get_photo&id=' + id,
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
			url: '/?app=' + APP + '&act=save_photos_v2',
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

// 选择软文链接
function select_content_link(e){
	var title = '选择要链接的文章';
    var url = '/?app=cms_controller_fdrs&act=select_content';
    mini.open({
		url: url,
		showModal: true,allowResize:false,
		title: title,
		width: 700,height: 380,
		ondestroy: function (action) { 
			if (action == 'ok') { 
				var iframe = this.getIFrameEl();
	            var data = iframe.contentWindow.selected_content;
	            data = mini.clone(data); 
	            set_content_id(data);
			}
		}
	});	
}

// 选择专题链接
function select_subject_link(e){
	var title = '选择要链接的专题';
    var url = '/?app=cms_controller_fdrs&act=select_subject';
    mini.open({
		url: url,
		showModal: true,allowResize:false,
		title: title,
		width: 700,height: 380,
		ondestroy: function (action) { 
			if (action == 'ok') { 
				var iframe = this.getIFrameEl();
	            var data = iframe.contentWindow.selected_content;
	            data = mini.clone(data); 
	            set_subject_id(data);
			}
		}
	});	
}

function set_content_id(data){
	mini.get('content_id').set(data);
	mini.get('subject_id').set({value:'',text:''});
}

function set_subject_id(data){
	mini.get('content_id').set({value:'',text:''});
	mini.get('subject_id').set(data);
}
</script>
</head>
<body>   
<div class="mini-fit">
	<div id="inputfrm1">
        <div class="mini-hidden" name="id" id="id"></div>
        <table border="0" class="table_default">
            <tr>
                <td width="110">标题：</td>
                <td><input id="title" name="title" class="mini-textbox" style="width:100%" 
                	emptyText="最长不要超过60个字符" vtype="maxLength:60" errorMode="border" /></td>
            </tr>
            <tr>
                <td>所属分类：</td>
                <td><input id="type_id" name="type_id" class="mini-treeselect" 
                	multiSelect="false" style="width:250px;" showNullItem="true"
                    showFolderCheckBox="true" showTreeIcon="false" textField="text_more"
                    required="true" errorMode="border" popupWidth="250"
                    allowInput="true" pinyinField="tag" emptyText="支持字母筛选" />
                    <label>例如：输入 “hd” 即可以找到 “活动”</label>
                </td>
            </tr>
            <tr>
                <td>照片：</td>
                <td><div id="fileupload1" class="mini-fileupload" name="Fdata" 
				    	limitType="*.gif;*.jpg;*.png" style="width: 40%" 
					    flashUrl="/resource/miniui/swfupload/swfupload.swf"
					    uploadUrl="/?app=photo_controller_fdrs&act=save_photos_v2" 
					    onuploadsuccess="onUploadSuccess" onuploaderror="onUploadError">
					</div>
                </td>
            </tr>
            <tr>
                <td>链接到文章：</td>
                <td><input id="content_id" name="content_id" class="mini-buttonedit" 
                	style="width:100%"  showClose="true" oncloseclick="onCloseClick" 
                	emptyText="点击右侧按钮去选择文章" errorMode="border" 
                	onbuttonclick="select_content_link" /></td>
            </tr>
            <tr>
                <td>链接到专题：</td>
                <td><input id="subject_id" name="subject_id" class="mini-buttonedit" 
                	style="width:100%"  showClose="true" oncloseclick="onCloseClick" 
                	emptyText="点击右侧按钮去选择专题" errorMode="border" 
                	onbuttonclick="select_subject_link" /></td>
            </tr>
            <tr>
                <td>简介：</td>
                <td><textarea class="mini-textarea" name="note" 
                	emptyText="最多不要超过200字的简介" errorMode="border"
                	style="width: 100%;height: 125px"></textarea>
                </td>
            </tr>
        </table>
        <div class="note_tips">
        	<p><b>填写说明：</b></p>
        	<p>标题不是必填项，仅作为图片标识</p>
        	<p>如果您重新上传了照片则会自动覆盖之前的照片</p>
        	<p>如果您选择了“链接到文章或专题”，则优先于“简介”展示该链接中的内容</p>
        </div>
    </div>
</div>
<div class="mini-toolbar bottom_bar">
    <a class="mini-button" onclick="save">保存</a>
</div>
</body>
</html>