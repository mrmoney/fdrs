
var desktpData = {
	menu: [{
		menuid: "m001",/*桌面*/
		"name": "1",
		app: ["m101","m102","m103","m104","m105","m106"]
	}, {
		menuid: "m002",/*开始菜单*/
		"name": "opening",
		app: ["m201",/*"m202","m203",*/"m204"]
	}],
	apps: {
		m101: {
			appid: "101",
			isicon: 1,
			icon: "&#xe65f;",
			iconclass: "layui-icon",
			iconbg: "#51555e",
			name: "动态内容",
			url: "/?app=cms_controller_fdrs&act=index",
			height: "550",
			width: "980"
			//full: 1
		},
		m102: {
			appid: "102",
			isicon: 1,
			icon: "&#xe65f;",
			iconclass: "layui-icon",
			iconbg: "#d3b59d",
			name: "静态内容",
			url: "/?app=config_controller_fdrs&act=index",
			height: "",
			width: ""
		},
		m103: {
			appid: "103",
			isicon: 1,
			icon: "&#xe67b;",
			iconclass: "layui-icon",
			iconbg: "#b074e6",
			name: "研究课题",
			url: "/?app=subject_controller_fdrs&act=index",
			height: "550",
			width: "900"
		},
		m104: {
			appid: "104",
			isicon: 1,
			icon: "&#xe620;",
			iconclass: "layui-icon",
			iconbg: "#d3b59d",
			name: "图片管理",
			url: "/?app=photo_controller_fdrs&act=index",
			height: "550",
			width: "900"
			//full: 1
		},
		m105: {
			appid: "105",
			isicon: 1,
			icon: "&#xe665;",
			iconclass: "layui-icon",
			iconbg: "#33378c",
			name: "会员管理",
			url: "/?app=member_controller_fdrs&act=index",
			height: "550",
			width: "900"
		},
		m106: {
			appid: "106",
			isicon: 1,
			icon: "&#xe6e8;",
			iconclass: "layui-icon",
			iconbg: "#109b8e",
			name: "用户管理",
			url: "/?app=sys_controller_fdrs&act=index",
			height: "500",
			width: "700"
		},
		m201: {
			appid: "101",
			isicon: 1,
			icon: "&#xe65f;",
			iconclass: "layui-icon",
			iconbg: "#51555e",
			name: "动态内容",
			url: "/?app=cms_controller_fdrs&act=index",
			height: "550",
			width: "900"
		},
		/*m202: {
			appid: "102",
			isicon: 1,
			icon: "&#xe646;",
			iconclass: "layui-icon",
			iconbg: "#60b979",
			name: "装备管理",
			url: "/?app=product_controller_fdrs&act=index",
			height: "550",
			width: "900"
		},
		m203: {
			appid: "103",
			isicon: 1,
			icon: "&#xe621;",
			iconclass: "layui-icon",
			iconbg: "#d3b59d",
			name: "订单管理",
			url: "/?app=order_controller_fdrs&act=index",
			height: "",
			width: ""
		},*/
		m204: {
			appid: "104",
			isicon: 1,
			icon: "&#xe65f;",
			iconclass: "layui-icon",
			iconbg: "#109b8e",
			name: "用户管理",
			url: "/?app=sys_controller_fdrs&act=index",
			height: "500",
			width: "700"
		}
	}
};