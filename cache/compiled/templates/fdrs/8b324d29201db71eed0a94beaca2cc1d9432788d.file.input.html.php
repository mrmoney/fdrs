<?php /* Smarty version Smarty-3.0.8, created on 2018-06-23 09:41:53
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/fdrs\user/input.html" */ ?>
<?php /*%%SmartyHeaderCode:270545b2da56110e715-91591578%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8b324d29201db71eed0a94beaca2cc1d9432788d' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/fdrs\\user/input.html',
      1 => 1526866278,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '270545b2da56110e715-91591578',
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
body,html{margin:0;padding:0;border:0;width:100%;height:100%;}
html body .searchbox .mini-buttonedit-icon{ 
	background:url(/resource/images/search.gif) no-repeat 50% 50%;
}
.table_default{ margin: 1em auto; }
</style>
<?php $_template = new Smarty_Internal_Template('../local_js.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<script type="text/javascript" src="/resource/jsencrypt.min.js"></script>        
<script type="text/javascript">
var pub_key = '<?php echo $_smarty_tpl->getVariable('public_key')->value;?>
';
var APP = '<?php echo $_smarty_tpl->getVariable('controller')->value;?>
';
var Id = <?php echo $_smarty_tpl->getVariable('Id')->value;?>
;
var ary_genders = [{id:'男'},{id:'女'}];
var ary_status = <?php echo $_smarty_tpl->getVariable('ary_status')->value;?>
;
var ary_user_roles = <?php echo $_smarty_tpl->getVariable('ary_user_roles')->value;?>
;
var data = <?php echo $_smarty_tpl->getVariable('data')->value;?>
;
$(document).ready(function(){ setTimeout(init,0); });
function init()
{
	mini.parse();
	set_required();
	var tip = new mini.ToolTip();
	tip.set({ target: document, selector: '[data-tooltip], [title]'	});
	
	mini.get('roles').loadList(ary_user_roles);
	init_page();
}

function init_page()
{
	if(Id > 0)
	{
		var frm1= new mini.Form('frm1');
		frm1.setData(data);
		mini.get('username').set( {enabled:false} );
	}	
	
	mini.get('roles').doValueChanged();
}

function set_required()
{
	var ary_data = new mini.Form('frm1').getData();
	for(var k in ary_data)
	{
		mini.get(k).set( { errorMode:'border' } );
		if(k == 'sex' || k == 'note'){ continue; }
		mini.get(k).set( {required:true} );
	}
	
	if(Id > 0){ mini.get('userpwd').set( {required:false} ); }
}

function save()
{
	var frm1 = new mini.Form('frm1');
	frm1.validate();
	if(!frm1.isValid()){ return; }

	var encrypt = new JSEncrypt();
	encrypt.setPublicKey(pub_key);

	var o = frm1.getData(true);
	o.Id = Id;
	o.userpwd = encrypt.encrypt(o.userpwd);	
	
	showloading('正在保存...');
	$.ajax({
		url: '/?app=' + APP + '&act=save_user',
		data: o,
		type: 'post',
		success: function (json)
		{
			successHandler(json,function(){
				if(json.code == 1){
					mini.alert(json.message,'',function(action){
						if(action == 'ok'){ closeWindow('ok'); }
					});
				}else{ mini.alert(json.message); }
			});
		},
		error: function (jqXHR, textStatus, errorThrown) { error_req(); }
	});
	
	return false;
}

function onCloseClick(e)
{
	var obj = e.sender;
	obj.setText('');
	obj.setValue('');	
	obj.doValueChanged();
}
</script>
</head>

<body>
<div class="mini-fit" id="frm1">
    <table border="0" cellspacing="0" cellpadding="2" class="table_default">
        <tr>
            <td>登录账户</td>
            <td><input name="username" id="username" class="mini-textbox" style="width:112px;" /></td>
            <td>登录密码</td>
            <td><input name="userpwd" id="userpwd" class="mini-textbox" style="width:100px;" /></td>
        </tr>
        <tr>
            <td>姓名</td>
            <td><input name="realname" id="realname" class="mini-textbox" 
            		style="width:58px;" />
                <input name="sex" id="sex" class="mini-combobox" data="ary_genders" textField="id" emptyText="性别" style="width:50px;" />
            </td>
            <td>账户状态</td>
            <td><input name="ustatus" id="ustatus" class="mini-combobox" showNullItem="true" data="ary_status" style="width:100px;" /></td>
        </tr>  
        <tr>
            <td>岗位角色</td>
            <td colspan="3"><input name="roles" id="roles" class="mini-treeselect" 
            					multiSelect="true" textField="id" valueField="id" 
            					parentField="pid" checkRecursive="true"  
            					oncloseclick="onCloseClick"
                                showFolderCheckBox="false"  expandOnLoad="true" 
                                showClose="true" style="width:100%;" /></td>
        </tr>  
        <tr>
            <td>联系手机</td>
            <td colspan="3"><input name="tel" id="tel" emptyText="数字,可作为登录账户" 
            			vtype="int;rangeLength:10,12" 
            		class="mini-textbox" style="width:100%;" /></td>
        </tr>  
        <tr>
            <td>备注</td>
            <td colspan="3"><textarea name="note" id="note" style="width:100%;height:60px;"
                             class="mini-textarea"></textarea></td>
        </tr> 
    </table>
</div> 
<div class="mini-toolbar bottom_bar">
    <a class="mini-button" onclick="save">保存</a>
    <span style="display:inline-block;width:25px;"></span>
    <a class="mini-button" onclick="closeWindow('close')">关闭</a>
</div>
</body>
</html>
