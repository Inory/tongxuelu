<?php

$this->pageTitle=Yii::app()->name . ' - Login';

?>

<h1>Login</h1>

<form id="registerForm" action="<?=Yii::app()->createUrl('passport/register')?>" method="POST">

	邮箱 <br />
	<input id="email" name="user[email]" type="text" size="26" /> <br />
	<input id="emailstate" type="hidden" value="0">

	密码 <br />
	<input id="password" name="user[password]" type="password" size="26" /> <br />

	<input type="submit" />
</form>

<script type="text/javascript">
// event
$(function(){
	$('#email').blur(function(){
		$.ajax({
			url : $(this).attr('action'),
			data : {action : 'checkEmail', email : $('#password').val()},
			type : 'POST',
			dataType : 'json',
			success : function(data){
				
			}
			error : function(){

			}
		});
	});
	$('#registerForm').submit(function(){


		this.preventDefault();
	});
});

// job
$(function(){

});
</script>