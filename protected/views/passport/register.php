<?php

$this->pageTitle=Yii::app()->name . ' - Login';

?>

<h1>注册</h1>

<form id="registerForm" action="<?=Yii::app()->createUrl('passport/register')?>" method="POST">

	邮箱 <br />
	<input id="email" name="user[email]" type="text" size="26" /> <div id="email_check_status"></div><br />
	<input id="emailstate" type="hidden" value="0">

	密码 <br />
	<input id="password1" name="user[password1]" type="password" size="26" /> <div id="pwd_check_status1"></div><br />

	再次输出密码 <br />
	<input id="password2" name="user[password2]" type="password" size="26" /> <div id="pwd_check_status2"></div><br />

	<input type="submit" />
</form>

<?php Yii::app()->getClientScript()->registerScriptFile('/js/validate.js'); ?>
<script type="text/javascript">
// variable
var $ecs = $('#email_check_status');
var $pcs1 = $('#pwd_check_status1');
var $pcs2 = $('#pwd_check_status2');

// event
$(function(){
	$('#email').blur(function(){
		if(validateEmail($('#email').val())){
			$ecs.html('请输出正确的邮箱地址。');
			return false;
		}

		$.ajax({
			url : $(this).attr('action'),
			data : {action : 'checkEmail', email : $('#email').val()},
			type : 'POST',
			dataType : 'json',
			success : function(data){
				if(data.c == 0)
					$ecs.html('恭喜，该邮箱未被注册。');
				else
					$ecs.html('该邮箱已被注册。');
			}
		});
	});

	$('#password1').blur(function(){
		
	});

	$('#registerForm').submit(function(){


		this.preventDefault();
	});
});

// job
$(function(){

});
</script>