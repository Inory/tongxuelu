<?php
class CallbackAction extends CAction
{
	public function run()
	{
		if(Kaori_Session::get('next') != 'success')
		{
			Kaori_Response::redirect('/');
		}

		if(isset($_GET['error']))
		{
			Kaori_Response::backToParentWindow('no_refresh');
		}

		Kaori_Session::set('next', null); // clear session
			
//		$state = $this->getRequest()->getParam('state');
		$authCode = $_GET['code'];
		if (!$authCode)
		{
			Kaori_Response::redirect('/');
		}

		$source = ucfirst(Kaori_Session::get('source'));
		$oauth = new $source; // load sina model

		$oauth->setData('code', $authCode); // 设置 authcode
		if (!$oauth->getAccessToken() || !$oauth->getTokenInfo() || !$oauth->getUserInfo()) // get user info
		{
			// Kaori_Response::redirect('/');
			echo "Oauth err : \n";
			$oauth->debug('ErrMsg');
		}
		$tpu = $this->getTpu($oauth->getUser('uid')); // load third party user model
		
		if ($tpu) // registered -> login
		{
			$uid = $this->getUid($tpu); // get uid
			$this->login($uid);
			Kaori_Response::backToLastPage();
		}
		else // not registered -> register
		{
			$this->register(array('oid' => $oauth->getUser('uid'), 'name' => $oauth->getUser('name'), 'source' => $source));
		}
	}

	protected function getTpu($oid)
	{
		return ThirdPartyUser::get($oid);
	}

	protected function getUid($tpu)
	{
		return $tpu->uid;
	}

	protected function login($uid)
	{
		$user = User::get($uid);
		$ui = new UserIdentity();
		$ui->id = $user->id;
		$ui->nickname = $user->nickname;
		return Yii::app()->user->login($ui);
	}

	protected function register($tpuData)
	{
		$time = date('Y-m-d H-m-s', time());

		try
		{
			$transaction= Yii::app()->db->beginTransaction();//创建事务
	
			// create new user 
			$user = new User;
			$user->nickname = $tpuData['name'];
			$user->email = Kaori_String::createUniqKey() . '@' . $tpuData['source'] . '.inory.org';
			$user->create_time = $time;
			if(!$user->save())
				throw new Exception('user save err!');

			// create new tpu
			$tpu = new ThirdPartyUser;
			$tpu->oid = $tpuData['oid'];
			$tpu->source = $tpuData['source'];
			$tpu->uid = $user->id;
			$tpu->create_time = $time;
			if(!$tpu->save())
				throw new Exception('tpu save err!');

			$transaction->commit();//提交事务
		}
		catch(Exception $e)
		{
			$transaction->rollback();
			echo $e->getMessage();
			Yii::app()->end();
		}

		// login
		$this->login($user->id);

		Kaori_Session::del('next'); // clear session

		Kaori_Response::backToLastPage();
	}

}