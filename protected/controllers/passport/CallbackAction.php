<?php
class CallbackAction extends CAction
{
	public function run()
	{
		session_start();
		if($_SESSION['next'] != 'success')
		{
			Kaori_Response::redirect('Denied!');
		}

		if(isset($_GET['error']))
		{
			Kaori_Response::backToParentWindow('no_refresh');
		}

		Kaori_Session::setSession('next', null); // clear session
			
//		$state = $this->getRequest()->getParam('state');
		$authCode = $_GET['code'];
		if (!$authCode)
		{
			Kaori_Response::redirect('出错了，请稍候重试！');
		}

		$oauth = new Sina; // load sina model

		$oauth->setData('code', $authCode); // 设置 authcode
		if (!$oauth->getAccessToken() || !$oauth->getTokenInfo() || !$oauth->getUserInfo()) // get user info
		{
			// Kaori_Response::redirect('出错了，请稍候重试！');
			echo "Oauth err : \n";
			$oauth->debug('ErrMsg');
		}
		$tpu = $this->getTpu($oauth->getUser('uid')); // load third party user model
		$uid = $this->getUid($tpu);
		if ($tpu) // registered -> login
		{
			$uid = $tpu->uid; // get uid
			$this->login($uid);
			Kaori_Response::backToLastPage();
		}
		else // not registered -> register
		{
			Kaori_Session::setSession('tpu', array('uid' => $oauth->getUser('uid'), 'name' => $oauth->getUser('name'), 'source' => 'sina'));
		}
	}

	protected function getTpu($oid)
	{
		return ThirdPartyUser::get($oid);
	}

	protected function getUid($tpu)
	{
		return isset($tpu->uid);
	}

	protected function login($uid)
	{
		$user = User::get($uid);
		$ui = new UserIdentity();
		$ui->id = $user->id;
		$ui->nickname = $user->nickname;
		return Yii::app()->user->login($ui);
	}

	protected function register()
	{

		$tpuModel = $this->tpu;
		$userModel = $this->user;

		$tpu = Kaori_Session::getSession('tpu');
		if($tpuModel->isExist($tpu['uid'])) // Is tpu existed?
		{
			echo 'Tpu already existed!';
			return;
		}

		// create new user new tpu
		// $email = Kaori_String::createUniqKey() . '@' . $source . '.inory.org';
		$password = Kaori_String::createUniqKey();
		$name = $tpu['name'];
		$source = $tpu['source'];
		$uid = $tpu['uid'];
		$pid = $userModel->create(array('name'=>$name,'password'=>$password));
		$tpuModel->create(array('uid'=>$uid,'pid'=>$pid,'source'=>$source));

		// login
		Kaori_Session::setSession('pid', $pid);
		Kaori_Session::setSession('name', $name);

		Kaori_Session::setSession('next', null); // clear session

		$data = Kaori_Aes::authcode(json_encode(array('pid'=>$pid,'uid'=>$uid,'name'=>$name,'source'=>$source)), 'ENCODE', Kaori_Aes::key, 60);

		// back
		echo Kaori_Response::backToParentWindow($data);
	}

}