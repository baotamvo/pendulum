<?php

/**
 * This is the model class for table "jobinterviews".
 *
 * The followings are the available columns in table 'jobinterviews':
 * @property integer $jobinterviewId
 * @property integer $jobapplicationId
 * @property string $datetime
 * @property string $location
 * @property string $description
 * @property integer $pending
 *
 * The followings are the available model relations:
 * @property Jobapplications $jobapplication
 */
class PDJobInterview extends PDActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PDJobInterview the static model class
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
		return 'jobinterviews';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jobapplicationId, datetime, pending', 'required'),
			array('jobapplicationId, pending', 'numerical', 'integerOnly'=>true),
			array('location', 'length', 'max'=>200),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jobinterviewId, jobapplicationId, datetime, location, description, pending', 'safe', 'on'=>'search'),
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
			'jobApplications' => array(self::HAS_MANY, app()->getClass('jobPosting/models/jobApplications'), 'jobinterviewId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jobinterviewId' => 'Jobinterview',
			'jobapplicationId' => 'Jobapplication',
			'datetime' => 'Datetime',
			'location' => 'Location',
			'description' => 'Description',
			'pending' => 'Pending',
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

		$criteria->compare('jobinterviewId',$this->jobinterviewId);
		$criteria->compare('jobapplicationId',$this->jobapplicationId);
		$criteria->compare('datetime',$this->datetime,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('pending',$this->pending);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}