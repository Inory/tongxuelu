<?php
class Sina extends Oauth
{
	const CLIENT_ID = '3319503368';
	const CLIENT_SECRET = '346fbae9bc2a4bd7ce9961628ba6d8c8';
	
	function __construct()
	{
		$host = $_SERVER['HTTP_HOST'];
		parent::__construct(self::CLIENT_ID, self::CLIENT_SECRET);
		
		$this->setConfig('redirUrl', self::BASE_URL.self::CALLBACK_URL);
		$this->setConfig('serverName', 'api.weibo.com');
		
		$this->setApiDirs('getCode', '/oauth2/authorize');
		$this->setApiDirs('getToken', '/oauth2/access_token');
		$this->setApiDirs('getTokenInfo', '/oauth2/get_token_info');
		$this->setApiDirs('getUserInfo', '/2/users/show.json');
	}

	public function buildGetAuthCodeHtml()
	{
		$params = array('client_id' => $this->getConfig('appId'),'response_type'=>'code','redirect_uri'=>$this->getConfig('redirUrl'));
		$url = Kaori_Curl::makeUrl($params, $this->getConfig('serverName'), $this->getApiDirs('getCode'), 'https');
		return Kaori_Curl::buildRedirLink($url, 'sina');
	}

	public function getAccessToken()
	{
		$params = array('grant_type' => 'authorization_code', 'client_id' => $this->getConfig('appId'), 'client_secret' => $this->getConfig('appKey'),
			'code' => $this->getData('code'), 'redirect_uri' => $this->getConfig('redirUrl'));
		$ret = Kaori_Curl::makeRequest($this->getApiUri('getToken'), $params, array(), 'post', 'https');
		if (true === $ret['result'])
		{
			$msg = json_decode($ret['msg'], true);
			if (isset($msg['access_token']))
			{
				$this->setData('token', $msg['access_token']);
				return true;
			}
			else
			{
				$this->setErrMsg($msg);
				return false;
			}
		}
		else
		{
			$this->setErrMsg(array('err' => 1, 'error_msg' => 'Connect error!'));
			return false;
		}
	}
	
	public function getTokenInfo()
	{
		$params = array('access_token' => $this->getData('token'));
		$ret = Kaori_Curl::makeRequest($this->getApiUri('getTokenInfo'), $params, array(), 'post', 'https');
		if (true === $ret['result'])
		{
			$msg = json_decode($ret['msg'], true);
			if (isset($msg['uid']))
			{
				$this->setUser('uid', $msg['uid']);
				return true;
			}
			else
			{
				$this->setErrMsg($msg);
				return false;
			}
		}
		else
		{
			$this->setErrMsg(array('err' => 1, 'error_msg' => 'Connect error!'));
			return false;
		}
	}
	
	public function getUserInfo()
	{
		$params = array('access_token' => $this->getData('token'), 'uid' => $this->getUser('uid'));
		$ret = Kaori_Curl::makeRequest($this->getApiUri('getUserInfo'), $params, array(), 'get', 'https');
		if (true === $ret['result'])
		{
			$msg = json_decode($ret['msg'], true);
			if (isset($msg['name']))
			{
				$this->setUser('name', $msg['name']);
				return true;
			}
			else
			{
				$this->setErrMsg($msg);
				return false;
			}
		}
		else
		{
			$this->setErrMsg(array('err' => 1, 'error_msg' => 'Connect error!'));
			return false;
		}
	}
}