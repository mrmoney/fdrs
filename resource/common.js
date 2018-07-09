function isMobile(phone){
	var r = /^(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/;  
	return r.test(phone);
}