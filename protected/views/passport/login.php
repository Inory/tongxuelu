<?php

$this->pageTitle=Yii::app()->name . ' - Login';

?>

<h1>Login</h1>

<form id="" action="<?=Yii::app()->createUrl('passport/login')?>" method="POST">

	用户名/邮箱 <br />
	<input type="text" size="26" /> <br />

	密码 <br />
	<input type="password" size="26" /> <br />

	<input type="submit" />

</form>

<script type="text/javascript">
// event
$(function(){

});

// job
$(function(){

});
</script>