<?php
/**
 * Description of PDRegistrationService
 *
 * @author BaoTam Vo
 */
class PDRegistrationService extends PDBaseService {
    public 
    $username,
    $password,
    $name,
    $retypedPassword,
    $email,
    $retypedEmail;
    
    protected 
    $_user,
    $_airline,
    $_userLogicAdapter,
    $_airlineLogicAdapter,
    $_userOrigData,
    $_airlineOrigData;

    public function __construct($newUserRecord, $newAirlineRecord, $userLogicAdapter, $airlineLogicAdapter) {
        $this->_user = $newUserRecord;
        $this->_airline = $newAirlineRecord;
        $userLogicAdapter->setDependable($newUserRecord);
        $airlineLogicAdapter->setDependable($newAirlineRecord);
        $this->_userLogicAdapter    = $userLogicAdapter;
        $this->_airlineLogicAdapter = $airlineLogicAdapter;
    }
    
    public function rules() {
        return array(
            array('name,username,password,retypedPassword,email,retypedEmail','required'),
            array('password, retypedPassword','length','min'=>5,'max'=>15),
            array('username','length','min'=>5,'max'=>20),
            array('retypedPassword','compare','compareAttribute'=>'password'),
            array('retypedEmail','compare','compareAttribute'=>'email')
        );
    }
    
    public function attributeLabels() {
        return array(
            'retypedPassword'=>'Retype Password',
            'retypedEmail'=>'Retype Email'
        );
    }
    
    protected function begin() {
        if(!parent::begin()) return false;
        $userLogicAdapter    = $this->_userLogicAdapter;
        $airlineLogicAdapter = $this->_airlineLogicAdapter;
        
        $userLogicAdapter->setAttributes($this->attributes);
        $userLogicAdapter->validate();
        $this->addErrors($userLogicAdapter->getErrors());

        $airlineLogicAdapter->setAttributes($this->attributes);
        $airlineLogicAdapter->validate();
        $this->addErrors($airlineLogicAdapter->getErrors());
        
        return !$this->hasErrors();
    }
    
    protected function process() {
        $this->_user->setRegisterTimeNow();
        $this->_user->setTypeAirline();
        return true;
    }
    
    public function commit() {
        $this->_airlineOrigData = $this->_airline->attributes;
        $this->_userOrigData    = $this->_user->attributes;
        
        $this->_user->encodePassword();
        if(!$this->_user->save()) brp($this->_user->errors);
        
        $this->_airline->userId = $this->_user->userId;
        if(!$this->_airline->save()) brp($this->_user->errors);
    }
    
    public function rollback() {
        $this->_airline->setAttributes($this->_airlineOrigData,false);
        $this->_user->setAttributes($this->_userOrigData,false);
    }
}

?>
