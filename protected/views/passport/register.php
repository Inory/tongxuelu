<?php

$this->pageTitle=Yii::app()->name . ' - Login';

?>

<h1>注册</h1>

<form id="registerForm" action="<?=Yii::app()->createUrl('passport/register')?>" method="POST">

	邮箱 <br />
	<input id="email" name="user[email]" type="text" size="26" /> <div id="email_validate_msg"></div><br />
	<input id="email_validate_status" type="hidden" value="1" />

	密码 <br />
	<input id="password1" name="user[password1]" type="password" size="26" /> <div id="pwd_validate_msg1"></div><br />

	再次输出密码 <br />
	<input id="password2" name="user[password2]" type="password" size="26" /> <div id="pwd_validate_msg2"></div><br />
	<input id="pwd_validate_status" type="hidden" value="1" />

	<input id="btn_register" type="submit" value="注册" disabled="disabled" />
</form>

<?php Yii::app()->getClientScript()->registerScriptFile('/js/validate.js'); ?>
<script type="text/javascript">
// variable
var $evm = $('#email_validate_msg');
var $pvm1 = $('#pwd_validate_msg1');
var $pvm2 = $('#pwd_validate_msg2');

var $evs = $('#email_validate_status');
var $pvs = $('#pwd_validate_status');

function enableRegister(){
	$('#btn_register').removeAttr('disabled');
}
function disableResiger(){
	$('#btn_register').attr('disabled');
}

// event
$(function(){
	$('#email').blur(function(){
		if(validateEmail($('#email').val())){
			$evm.html('请输出正确的邮箱地址。');
			$evs.val(1);
			return false;
		}

		$.ajax({
			url : $(this).attr('action'),
			data : {action : 'checkEmail', email : $('#email').val()},
			type : 'POST',
			dataType : 'json',
			success : function(data){
				if(data.c == 0){
					$evm.html('恭喜，该邮箱未被注册。');
					$evs.val(0);
				}
				else{
					$evm.html('该邮箱已被注册。');
					$evs.val(1);
				}
			}
		});
	});

	$('#password1').keyup(function(){
		
	});

	$('#password1').keyup(function(){
		
	});

	$('#registerForm').submit(function(){

	});
});

// job
$(function(){

});
</script>