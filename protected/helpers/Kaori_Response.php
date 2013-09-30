<?php
class Kaori_Response
{
	public static function printErrMsg($msg)
	{
		header("Content-type:text/html;charset=utf-8");
		echo $msg;
		die();
	}

	public static function redirect($url = '/')
	{
		header('HTTP/1.1 302 Moved Temporarily');
		header('Location: ' . $url);
		die();
	}

	public static function redirectByScript($url = '/')
	{
		$html = '<script type="text/javascript">document.loaction="'.$url.'"</script>';
		echo $html;
		die();
	}

	public static function iframeCrossDomain($data)
	{
		$data = urlencode($data);
		$setDataScript = 'window.opener.name="'.$data.'";window.opener.location="http://test.amleaf.com/auth/proxy.html";';
		$closeScript = 'window.close();';
		$html = '<script type="text/javascript">' . $setDataScript . $closeScript . '</script>';
		echo $html;
		die();
	}

	public static function backToParentWindow($refresh = 'refresh')
	{
		$refreshScript = $refresh == 'refresh' ? 'window.opener.location.reload();' : '';
		$closeScript = 'window.close();';
		$html = '<script type="text/javascript">' . $refreshScript . $closeScript . '</script>';
		echo $html;
		die();
	}

	public static function backToLastPage()
	{
		$url = Yii::app()->user->returnUrl;
		$backScript = 'window.opener.location="'.$url.'";';
		$closeScript = 'window.close();';
		$html = '<script type="text/javascript">' . $backScript . $closeScript . '</script>';
		echo $html;
		die();
	}
}