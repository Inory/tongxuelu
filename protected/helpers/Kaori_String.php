<?php

class Kaori_String
{
	public static function createRandomString($len)
	{
		$str = '';
		for ($i = 0; $i < $len; $i++)
		{
			$str .= chr(mt_rand(33, 126));
		}
		return $str;
	}

	public static function createRandomNumber($len)
	{
		$str = '';
		for ($i = 0; $i < $len; $i++)
		{
			$str .= chr(mt_rand(48, 57));
		}
		return $str;   
	}
	
	public static function createUniqKey()
	{
		return md5(self::createRandomString(6) . microtime());
	}
}