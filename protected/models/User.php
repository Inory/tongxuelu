<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $nickname
 * @property string $email
 * @property string $salt
 * @property string $pwd
 *
 * The followings are the available model relations:
 * @property Class[] $classes
 * @property UserProfile $userProfile
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('nickname, email', 'required'),
			array('mobile_phone', 'length', 'min'=>12,'max'=>12),
			array('nickname', 'length', 'max'=>30),
			array('email', 'length', 'max'=>128),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'classes' => array(self::MANY_MANY, 'Class', 'classmate(uid, cid)'),
			'userProfile' => array(self::HAS_ONE, 'UserProfile', 'uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'nickname' => '昵称',
			'email' => '邮箱',
		);
	}

	public function validatePassword($pwd)
	{
		return $this->password === $this->generatePassword($pwd);
	}

	public function generatePassword($pwd)
	{
		return md5($this->salt . md5($pwd) . $this->salt);
	}

	public static function get($id)
	{
		return self::model()->find('id = ?',array($id));
	}
}