<h1>welcome to inory.org!</h1>


<?php if(Yii::app()->user->getIsGuest()):?>
<a href="<?php echo Yii::app()->user->loginUrl[0]; ?>">登录</a>
<?php endif; ?>