<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CBaseUserIdentity
{
	public $id;
	public $passid;
	public $name;
	public $email;
	public $password;

	public function __construct($passid, $password)
	{
		$this->passid = strtolower($passid);
		$this->password = $password;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function authenticate()
	{
		$user = User::model()->find('email = ? OR name = ?', array($this->passid, $this->passid));
		if($user === null)
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		else if(!$user->validatePassword($this->password))
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->id = $user->id;
			$this->name = $user->name;
			$this->errorCode = self::ERROR_NONE;
		}
		return $this->errorCode == self::ERROR_NONE;
	}

}