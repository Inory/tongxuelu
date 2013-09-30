<?php
/**
 * tencent oauth class
 */
class Tencent extends Oauth
{

	const TPL_GET_AUTH_CODE_API_URI = '/oauth2.0';
	const GET_TOKEN_API_URI = '/oauth2.0/token';
	const GET_OPEN_ID_API_URI = '/oauth2.0/me';
	const GET_USER_INFO_API_URI = '/user/get_user_info';

	const CLIENT_ID = '100527023';
	const CLIENT_SECRET = '7605cd04ead11509e38897ee9f0bd36c';

	function __construct()
	{
		parent::__construct(self::CLIENT_ID, self::CLIENT_SECRET);
		
		$this->setConfig('redirUrl', self::BASE_URL.self::CALLBACK_URL);
		$this->setConfig('serverName', 'graph.qq.com');
		
		$this->setApiDirs('getCode', '/oauth2.0/authorize');
		$this->setApiDirs('getToken', '/oauth2.0/token');
		$this->setApiDirs('getTokenInfo', '/oauth2.0/me');
		$this->setApiDirs('getUserInfo', '/user/get_user_info');
	}

	public function buildGetAuthCodeHtml()
	{
		$params = array('response_type'=>'code','client_id' => $this->getConfig('appId'),'redirect_uri'=>$this->getConfig('redirUrl'),'scope'=>'','state'=>'');
		$url = Kaori_Curl::makeUrl($params, $this->getConfig('serverName'), $this->getApiDirs('getCode'), 'https');
		return Kaori_Curl::buildRedirLink($url, 'qq');
	}


	public function getAccessToken()
	{
		$params = array('grant_type' => 'authorization_code', 'client_id' => $this->getConfig('appId'), 'client_secret' => $this->getConfig('appKey'),
			'code' => $this->getData('code'), 'redirect_uri' => $this->getConfig('redirUrl'));
		$ret = Kaori_Curl::makeRequest($this->getApiUri('getToken'), $params, array(), 'post', 'https');
		if (true === $ret['result'])
		{
			preg_match('/(?<==)[\w\d]+(?=&)/', $ret['msg'], $matches);
			if (isset($matches[0]))
			{
				$this->setData('token', $matches[0]);
				return true;
			}
			else
			{
				preg_match('/{.*}/', $ret['msg'], $matches);
				$this->setErrMsg(json_decode($matches[0], true));
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
			preg_match('/{.*}/', $ret['msg'], $matches);
			$msg = json_decode($matches[0], true);
			if (isset($msg['openid']))
			{
				$this->setUser('uid', $msg['openid']);
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
		$params = array('oauth_consumer_key' => $this->getConfig('appId'), 'access_token' => $this->getData('token'), 'openid' => $this->getUser('uid'));
		$ret = Kaori_Curl::makeRequest($this->getApiUri('getUserInfo'), $params, array(), 'post', 'https');
		if (true === $ret['result'])
		{
			$msg = json_decode($ret['msg'], true);
			if (0 == $msg['ret'])
			{
				$this->setUser('name', $msg['nickname']);
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

	private static function isOpenId($openid)
	{
		return (0 == preg_match('/^[0-9a-fA-F]{32}$/', $openid)) ? false : true;
	}

}