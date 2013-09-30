<?php
class Kaori_Session
{
	public static function get($key)
	{
		if(!isset(Yii::app()->session[$key]))
			return false;
		return Yii::app()->session[$key];
	}

	public static function set($key, $value)
	{
		Yii::app()->session[$key] = $value;
	}

	public static function del($key)
	{
		unset(Yii::app()->session[$key]);
	}
}