<?php

/**
 * Description of PDUserIdentity
 *
 * @author BaoTam Vo
 */
class PDUserIdentity extends PDService implements IUserIdentity {
    
    public $username;
    public $password;
    
    protected $_persistentState = array();
    
    public function authenticate() {
        $users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->addError('username',self::ERROR_USERNAME_INVALID);
            
		if($users[$this->username]!==$this->password)
			$this->addError('password',self::ERROR_PASSWORD_INVALID);
		
        
		return !$this->errorCode;
    }


    public function getId() {
        return 'userIdentity_'.$this->username;
    }

    public function getIsAuthenticated() {
        !$this->hasErrors();
    }

    public function getName() {
        $this->username;
    }

    public function getPersistentStates() {
        
    }

    public function process() {
        
    }
}

?>
