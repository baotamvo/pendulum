<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $userId
 * @property string $ID
 * @property string $user_login
 * @property string $user_pass
 * @property string $user_nicename
 * @property string $user_email
 * @property string $user_registered
 * @property string $user_activation_key
 * @property integer $user_status
 * @property string $display_name
 * @property integer $usertypeId
 * @property string $user_url
 *
 * The followings are the available model relations:
 * @property $airline
 * @property Errorlog[] $errorlogs
 * @property Passwordrecoverytokens[] $passwordrecoverytokens
 * @property $pilot
 * @property Recruiters[] $recruiters
 * @property Thirdpartyusers[] $thirdpartyusers
 * @property Useractivation[] $useractivations
 */
class PDUser extends PDActiveRecord
{


	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PDUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function behaviors() {
        return array(
            'accountTypeManager'=>app()->getModule('account')->aspects->get('accountTypeManager'),
        );
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_registered', 'required'),
			array('user_status, usertypeId', 'numerical', 'integerOnly'=>true),
			array('ID', 'length', 'max'=>20),
			array('user_activation_key', 'length', 'max'=>60),
            array('user_login','match','pattern'=>'/^([A-Za-z0-9_@.])+$/','message'=>'Only letters, numbers, underscores, points, and @ are allowed '),
            array('user_email,user_login','unique','criteria'=>array(
                'scopes'=>array('addNotSelfScope'=>array($this))
            )),
			array('user_pass', 'length', 'max'=>64),
            array('user_email','email'),
			array('user_nicename', 'length', 'max'=>50),
			array('user_email, user_url', 'length', 'max'=>100),
			array('display_name', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('userId, ID, user_login, user_pass, user_nicename, user_email, user_registered, user_activation_key, user_status, display_name, usertypeId, user_url', 'safe', 'on'=>'search'),
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
			'airline' => array(self::HAS_ONE, app()->getClass('airline/models/airline'), 'userId'),
            'type' => array(self::BELONGS_TO, app()->getClass('account/models/userType'), 'usertypeId'),
			'pilot' => array(self::HAS_ONE, app()->getClass('pilot/models/pilot'), 'userId'),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'userId' => 'User',
			'ID' => 'ID',
			'user_login' => 'Username',
			'user_pass' => 'Password',
			'user_nicename' => 'User Nicename',
			'user_email' => 'User Email',
			'user_registered' => 'User Registered',
			'user_activation_key' => 'User Activation Key',
			'user_status' => 'User Status',
			'display_name' => 'Display Name',
			'usertypeId' => 'Usertype',
			'user_url' => 'User Url',
		);
	}


	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('userId',$this->userId);
		$criteria->compare('ID',$this->ID,true);
		$criteria->compare('user_login',$this->user_login,true);
		$criteria->compare('user_pass',$this->user_pass,true);
		$criteria->compare('user_nicename',$this->user_nicename,true);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('user_registered',$this->user_registered,true);
		$criteria->compare('user_activation_key',$this->user_activation_key,true);
		$criteria->compare('user_status',$this->user_status);
		$criteria->compare('display_name',$this->display_name,true);
		$criteria->compare('usertypeId',$this->usertypeId);
		$criteria->compare('user_url',$this->user_url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public function encodePassword() {
        $this->user_pass = app()->passwordHasher->hashPassword($this->user_pass);
    }


    public function checkPassword($password) {
        return app()->passwordHasher->checkPassword($password, $this->user_pass);
    }

    public function setRegisterTimeNow() {
        $this->user_registered = new CDbExpression('NOW()');
    }

    public function getFullName() {
        if($this->pilot)
            return $this->pilot->fullName;
        if($this->display_name)
            return $this->display_name;
        return $this->user_login;
    }
}