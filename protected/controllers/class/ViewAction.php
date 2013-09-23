<?php
class ViewAction extends CAction
{
	public function run($id)
	{
		echo $id;
		var_dump(Yii::app()->user->name);
	}
}