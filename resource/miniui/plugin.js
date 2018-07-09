//全屏
function toggleFullScreen() 
{
	if(!$.browser.msie)
	{
		if ((document.fullScreenElement && document.fullScreenElement !== null) ||    // alternative standard method
		  (!document.mozFullScreen && !document.webkitIsFullScreen)) {               // current working methods
			if (document.documentElement.requestFullScreen) {document.documentElement.requestFullScreen();} 
			else if (document.documentElement.mozRequestFullScreen) {document.documentElement.mozRequestFullScreen();} 
			else if (document.documentElement.webkitRequestFullScreen) 
			{document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);}
		} else {
			if (document.cancelFullScreen) {document.cancelFullScreen();} 
			else if (document.mozCancelFullScreen) {document.mozCancelFullScreen();} 
			else if (document.webkitCancelFullScreen) {document.webkitCancelFullScreen();}
		}
	}
}
//由miniui来调用是否开启全屏的对话框
function call_fullscreen()
{
	if(!$.browser.msie)
	{
		top.mini.confirm("您需要开启全屏模式吗？<br/>点击 \"确定\" 按钮开启<br/>否则点击 \"取消\" 按钮", "提示",
			function (action) {if (action == "ok") {toggleFullScreen();}}
		);
	}
}
//刷新最外层当前打开的选项卡
function reload_active_tab()
{
	var tabs = null;try{tabs = mini.get("mainTabs");}catch(err){return;}
	var tab = tabs.getActiveTab();
	tabs.reloadTab(tab);
}
//启动打开帮助向导提示
function start_help_tips(){mini.showTips({content: '当前功能栏目有帮助向导可用，如有需要请点击顶部导航栏中的 “帮助” 菜单',state: "success",x: "center",y: "center",timeout: 6000});}
function boot_help(){try{startIntro();}catch(err){alert('当前模块没有相关帮助向导');}}
var alertFun = window.alert;window.alert = function (e) {if (e != null && e.indexOf("www.miniui.com")>-1){/*do nothing*/}else{alertFun (e);}};