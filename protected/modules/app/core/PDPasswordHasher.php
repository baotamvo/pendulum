<?php

/**
 * Description of PDPasswordHasher
 *
 * @author BaoTam Vo
 */
class PDPasswordHasher extends CApplicationComponent {
    private $_hasher;
    
    public function __construct() 
    {
        $this->init();
    }
    
    public function init()
    {
        $this->_hasher = $this->getHasher();
    }
    
    protected function getHasher() {
        Yii::import('ext.PasswordHash');
        return new PasswordHash(8, false);
    }
    
    public function hashPassword($password)
    {
        return $this->_hasher->HashPassword($password);
    }
    
    public function checkPassword($password, $stored_hash)
    {
        return  $this->_hasher->CheckPassword($password, $stored_hash);
    }
    
}

?>
