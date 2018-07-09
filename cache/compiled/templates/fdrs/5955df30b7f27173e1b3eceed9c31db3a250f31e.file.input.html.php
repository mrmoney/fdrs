<?php /* Smarty version Smarty-3.0.8, created on 2018-06-23 16:17:38
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/fdrs\subject/input.html" */ ?>
<?php /*%%SmartyHeaderCode:99595b2e02226c67b9-21452652%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5955df30b7f27173e1b3eceed9c31db3a250f31e' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/fdrs\\subject/input.html',
      1 => 1529741674,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '99595b2e02226c67b9-21452652',
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
.table_default{ width:98%!important; margin: 5px auto; }
.editor_c{ margin: 5px auto;width: 98%; }
</style>
<?php $_template = new Smarty_Internal_Template('../local_js.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<script src="<?php echo $_smarty_tpl->getVariable('res')->value;?>
/miniui/swfupload/swfupload.js" type="text/javascript"></script>
<script type="text/javascript">
var id = '<?php echo $_smarty_tpl->getVariable('id')->value;?>
';
var APP = '<?php echo $_smarty_tpl->getVariable('controller')->value;?>
';
var editor,return_data = null;
$(document).ready(function(){ setTimeout(init,0); });
function init(){ 
	mini.parse(); 
	create_fckeditor();
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
						return_data = data;
						if(data != null){
							var frm = new mini.Form("inputfrm1");
							frm.setData(data.frm);
							editor.html(data.frm.detail);
							/*setTimeout(function () {
								grid_upload.setData(data.photos);
							}, 500);*/
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
	var o = frm.getData(true);

	var fileupload = mini.get("fileupload1");
	if(o.del_sign != 'false' || fileupload.getText() == ''){
    	var text = editor.html();
		o.detail = text;

		showloading('正在保存...');
		$.ajax({
			url: '/?app=' + APP + '&act=save_subject',
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
    	var text = editor.html();
		o.detail = text;
    	fileupload.setPostParam(o);
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

<?php if ($_smarty_tpl->getVariable('id')->value>0){?>
function view_photo() {
	if(return_data == null || return_data.photos == null){ 
		mini.alert('没有可预览的照片');
		return;
	}
	var datas = {
          "title": return_data.frm.topic, //相册标题
          "id": return_data.frm.id, //相册id
          "start": 0, //初始显示的图片序号，默认0
          "data": []
    };

    var items = return_data.photos;
    for(var i = 0;i < items.length; i++){
        var item = items[i];
        var data = {};
        data.alt = return_data.frm.topic;
        data.src = item.srv_data.b_path;
        data.thumb = item.srv_data.s_path;
        datas.data.push(data);
    }

    desktop.photos(datas);
}

function onchange_delsign(e){
	var fileupload = mini.get("fileupload1");
	var checked = this.getChecked();
    // mini.alert(checked);
    fileupload.set({enabled:!checked});
}
<?php }?>
</script>
</head>
<body>   
<div class="mini-fit">
    <div id="inputfrm1">
        <div class="mini-hidden" name="id" id="id"></div>
        <table border="0" class="table_default">
            <tr>
                <td width="80">课题名称：</td>
                <td colspan="3"><input id="topic" name="topic" class="mini-textbox" 
                	required="true" errorMode="border" style="width:100%" 
                	emptyText="最长不要超过60个字符" vtype="maxLength:60" /></td>
            </tr>
            <tr>
                <td>封面照片：</td>
                <td><div id="fileupload1" class="mini-fileupload" name="Fdata" 
				    	limitType="*.gif;*.jpg;*.png" style="width: 40%" 
					    flashUrl="/resource/miniui/swfupload/swfupload.swf"
					    uploadUrl="/?app=<?php echo $_smarty_tpl->getVariable('controller')->value;?>
&act=save_subject" 
					    onuploadsuccess="onUploadSuccess" onuploaderror="onUploadError">
					</div>
					<?php if ($_smarty_tpl->getVariable('id')->value>0){?>
					<div class="mini-checkbox" id="del_sign" name="del_sign" 
						text="删除" onvaluechanged="onchange_delsign"></div>
					<span class="separator"></span>
					<a class="mini-button" onclick="view_photo">预览</a>
					<?php }?>
                </td>
            </tr>
        </table>
    </div>

	<table border="0" cellpadding="0" cellspacing="0" class="editor_c">
        <tr>
            <td><textarea id="detail" name="detail" 
            	style="width:100%;height:380px;visibility:hidden"></textarea></td>
        </tr>
    </table>
</div>
<div class="mini-toolbar bottom_bar">
    <a class="mini-button" onclick="save">保存</a>
</div>
</body>
</html>