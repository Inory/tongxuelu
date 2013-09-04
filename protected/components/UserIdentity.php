<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	public $id;
	public $nickname;

	public $loginIdentity;
	public $password;
	
	public function __construct($loginIdentity = '', $password = '')
	{
		$this->loginIdentity = strtolower($loginIdentity);
		$this->password = $password;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->nickname;
	}

	public function authenticate()
	{
		$user = User::model()->find('email = ? OR mobile_phone = ?', array($this->loginIdentity, $this->loginIdentity));
		if($user === null)
			$this->errorCode = ErrorCode::USER_NOT_EXIST;
		else if(!$user->validatePassword($this->password))
			$this->errorCode = ErrorCode::PASSWORD_INVALID;
		else
		{
			$this->id = $user->id;
			$this->nickname = $user->nickname;
			$this->errorCode = ErrorCode::NONE;
		}
		return $this->errorCode == ErrorCode::NONE;
	}

}