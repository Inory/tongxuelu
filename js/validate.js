function validateEmail(email){
	var patt = new RegExp('^([a-zA-Z0-9]*[-_]?[a-zA-Z0-9]+)*@([a-zA-Z0-9]*[-_]?[a-zA-Z0-9]+)+[\.][a-zA-Z]{2,3}([\.][a-zA-Z]{2})?$');
	if(!email || patt.test(email))
		return 0;
	else
		return 1;
}

function validatePwd(pwd)
{

}

function validateQq(qq){
	qq = String(qq);
	var patt = new RegExp("^[1-9][0-9]{4,14}$");
	if(!qq || patt.test(qq)){
		return 0;
	}
	else{
		return 1;
	}
}

function validateCellphone(cellphone){
	cellphone = String(cellphone);
	var patt = new RegExp("^1[1-9][0-9]{9}$");
	if(!cellphone || utf8strlen(cellphone) > 16 || patt.test(cellphone)){
		return 0;
	}
	else{
		return 1;
	}
}

function validatenNickname(nickname){
	if(utf8strlen(nickname) < 3){
		$(tdid).html(ERROR_TIPS.replace(":errmsg", "你输入的字数过少！"));
		return 1;
	}
	if(utf8strlen(nickname) > 12){
		$(tdid).html(ERROR_TIPS.replace(":errmsg", "你输入的字数过多！"));
		return 2;
	}
	pttr = new RegExp("^[\u4e00-\u9fa5A-Za-z]$");
	if(!pttr.test(nickname.charAt(0))){
		$(tdid).html(ERROR_TIPS.replace(":errmsg", "首字符不能为数字下划线和横线！"));
		return 3;
	}
	pttr = new RegExp("^[^\u4e00-\u9fa5A-Za-z0-9-_]+$");
	if(pttr.test(nickname)){
		$(tdid).html(ERROR_TIPS.replace(":errmsg", "你输入的内容不合法！"));
		return 4;
	}
	pttr = new RegExp("^[\u4e00-\u9fa5A-Za-z][\u4e00-\u9fa5-_A-Za-z0-9]+$");
	if(!pttr.test(nickname)){
		$(tdid).html(ERROR_TIPS.replace(":errmsg", "你输入的内容不合法！"));
		
		return 5;
	}
}

function validateRealname(text){
	pttrChs = new RegExp("^[\u4e00-\u9fa5]+$");
	pttrEng = new RegExp("^[A-Z]?[a-z]+[ ]?[A-Z]?[a-z]+$");
	if(pttrChs.test(text)){
		if(utf8strlen(text) < 4){
			$(tdid).html(ERROR_TIPS.replace(":errmsg", "你输入的字数过少！"));
			return 1;
		}
		if(utf8strlen(text) > 12){
			$(tdid).html(ERROR_TIPS.replace(":errmsg", "你输入的字数过多！"));
			return 2;
		}
	}
	else if(pttrEng.test(text)){
		if(utf8strlen(text) < 3){
			$(tdid).html(ERROR_TIPS.replace(":errmsg", "你输入的字数过少！"));
			return 1;
		}
		if(utf8strlen(text) > 12){
			$(tdid).html(ERROR_TIPS.replace(":errmsg", "你输入的字数过多！"));
			return 2;
		}
	}
	else{
		$(tdid).html(ERROR_TIPS.replace(":errmsg", "请使用纯中文或者纯英文！"));
		return 3;
	}
	$(tdid).html(OK_TIPS);
	return 0;
}