<?php

/**
 * This is the model class for table "usertypes".
 *
 * The followings are the available columns in table 'usertypes':
 * @property integer $usertypeId
 * @property string $usertype
 */
class PDUserType extends PDActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PDUserType the static model class
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
		return 'usertypes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usertype', 'length', 'max'=>255),
            array('code', 'length', 'max'=>200),
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
            'users' => array(self::HAS_MANY, app()->getModule('account')->models->getClass('user'), 'usertypeId'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
//			'usertypeId' => 'Usertype',
//			'usertype' => 'User ype',
		);
	}

}