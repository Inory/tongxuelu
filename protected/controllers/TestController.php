<?php
class TestController extends Controller
{
	public function actions()
	{
		return array(
			'index'=>'application.controllers.test.IndexAction',
		);
	}
	
	public function actionTa()
	{
		echo 't action';
		var_dump(Yii::app()->user);
	}
}