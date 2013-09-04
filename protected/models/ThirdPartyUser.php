<?php

/**
 * This is the model class for table "third_party_user".
 *
 * The followings are the available columns in table 'third_party_user':
 * @property string $oid
 * @property string $uid
 * @property string $source
 *
 * The followings are the available model relations:
 * @property User $u
 */
class ThirdPartyUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ThirdPartyUser the static model class
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
		return 'third_party_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('oid, uid, source', 'required'),
			array('oid', 'length', 'max'=>32),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'u' => array(self::BELONGS_TO, 'User', 'uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'oid' => 'Oid',
			'uid' => 'Uid',
			'source' => 'Source',
		);
	}


	public static function get($oid)
	{
		return self::model()->find('oid = ?', array($oid));
	}
}