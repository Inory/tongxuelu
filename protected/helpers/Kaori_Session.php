<?php
class Kaori_Session
{
	public static function getSession($key)
	{
		if(!isset($_SESSION[$key]))
			return false;
		return $_SESSION[$key];
	}

	public static function setSession($key, $value)
	{
		$_SESSION[$key] = $value;
	}
}
