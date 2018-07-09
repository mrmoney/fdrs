<?php /* Smarty version Smarty-3.0.8, created on 2018-06-22 11:49:33
         compiled from "E:\mrmoney\baoxiang\fdrs\/templates/fdrs\../local_js.html" */ ?>
<?php /*%%SmartyHeaderCode:68865b2c71cd37dae9-90509659%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '678d33904a938a5c334cc3ade00e96e74e566348' => 
    array (
      0 => 'E:\\mrmoney\\baoxiang\\fdrs\\/templates/fdrs\\../local_js.html',
      1 => 1528932283,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '68865b2c71cd37dae9-90509659',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script src="<?php echo $_smarty_tpl->getVariable('cdn_host')->value;?>
/common/jquery-2.1.4.min.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->getVariable('res')->value;?>
/miniui/boot.js" type="text/javascript"></script>
<script type="text/javascript">
var layer=top.desktop.layer,desktop=top.desktop;function successHandler(o,n){if(hideloading(),void 0!==o.code)if(-1==Number(o.code)){top.isTimeOut=!0;var e=o.msg+"<br/>点击确定后将引导您重新登录";mini.confirm(e,"",function(o){"ok"==o&&(top.location.href="/?app=sysauth_controller_default&act=logout")})}else n();else mini.alert("系统繁忙,请稍候")}function showloading(o){void 0===o&&(o="请稍候 ..."),mini.mask({el:document.body,cls:"mini-mask-loading",html:o})}function hideloading(){mini.unmask(document.body)}function close_me(){var o=parent.layer.getFrameIndex(window.name);parent.layer.close(o)}function error_req(){hideloading(),mini.alert("网络异常,请稍后再试")}function reload_active_tab(){try{var o=mini.get("mainTabs"),n=o.getActiveTab();o.reloadTab(n)}catch(o){location.href=window.location}}function closeWindow(o){if(window.CloseOwnerWindow)return window.CloseOwnerWindow(o);window.close()}function Trim(o){return o.replace(/(^\s*)|(\s*$)/g,"")}
</script>
