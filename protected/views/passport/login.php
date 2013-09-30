<?php

$this->pageTitle=Yii::app()->name . ' - Login';

?>

<h1>Login</h1>

<form id="" action="<?=Yii::app()->createUrl('passport/login')?>" method="POST">

	用户名/邮箱 <br />
	<input type="text" size="26" /> <br />

	密码 <br />
	<input type="password" size="26" /> <br />

	<input type="submit" value="登录" />

</form>
<a class="btn_tpl" id="sina_tpl" href="/passport/thirdpartylogin?source=sina">sina login</a>
<a class="btn_tpl" id="sina_tpl" href="/passport/thirdpartylogin?source=qq">qq login</a>
<script type="text/javascript">
// event
$(function(){
	// third party login
	$("a.btn_tpl").click(function(event){
	    event.preventDefault();
	    var width = 680;
	    if(this.id == 'alipay_login'){
	        width = 960;
	    }
	    var w = window.open(this.href, this.id, "width=" + width + ",height=500,menubar=0,scrollbars=1,resizable=1,status=1,titlebar=0,toolbar=0,location=1");
	    w.focus();
	});
});

// job
$(function(){

});
</script>