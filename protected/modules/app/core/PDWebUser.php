<?php
/**
 * Date: 1/29/13
 * Class: PDWebUser
 * Description:
 *
 */
class PDWebUser extends CWebUser {

    protected
    $_airline = null,
    $_user = null;

    public function getAirline() {
        if(isset($this->airlineId) && !$this->_airline) {
            $this->_airline = app()->getModule('airline')
                ->models->get('airline')->getResource()
                ->findByPk($this->airlineId);
        }
        return $this->_airline;
    }

    public function getUser() {
        if(isset($this->userId) && !$this->_user) {
            $this->_user = app()->getModule('account')
                ->models->get('user')->getResource()
                ->findByPk($this->userId);
        }
        return $this->_user;
    }

    public function getId() {
        return !$this->isGuest ? $this->userId : 'guest@'.CHttpRequest::getUserHostAddress();
    }

    public function getName() {
        return !$this->isGuest ? parent::getName() : 'Guest';
    }

    public function checkAccess($operation,$params=array(),$allowCaching=true) {
//        return parent::checkAccess($operation,$params,$allowCaching);
        return true;
    }

    public function getFlashCollection($key) {
        if(!($values = $this->getFlash($key,null,false))) {
            $this->setFlash($key,new CList());
        }
    }

    public function addFlashException($error) {
        $this->getFlashExceptions()->add($error);
    }

    public function getFlashExceptions() {
        return $this->getFlashCollection('__exceptions');
    }

}
