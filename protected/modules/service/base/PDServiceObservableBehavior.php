<?php

/**
 * Description of PDObservableBehavior
 *
 * @author BaoTam Vo
 */
class PDServiceObservableBehavior extends CBehavior {
    const OBSERVER_DEFAULT_ID = 'default';
    protected $_observers;
    
    public function __construct($observers = array()) {
        $this->_observers = $observers;
    }
    
    public function addObserver($observer, $id = self::OBSERVER_DEFAULT_ID) {
        $this->_observers[$id] = $observer;
        return $this;
    }
    
    public function removeObserver($observer, $id = self::OBSERVER_DEFAULT_ID) {
        unset($this->_observers[$id]);
        return $this;
    }
    
    public function &getObserver($id = self::OBSERVER_DEFAULT_ID) {
        if(!isset($this->_observers[$id]))
            throw new InvalidArgumentException('The observer with id "'.$id.'" does not exist.');
        return $this->_observers[$id];
    }
    
    /**
     * notify an observer
     * @param mixed $directives a single directive or an array of directives
     * @param mixed $id
     * @return \PDBaseService
     */
    public function notifyObserver($directives, $id = self::OBSERVER_DEFAULT_ID) {
        $this->getObserver()->execute($directives);
        return $this;
    }
    
    public function notifyObservers($directives) {
        foreach($this->getObservers() as $observer) {
            $observer->execute($directives);
        }
        return $this;
    }
    
    public function &getObservers() {
        return $this->_observers;
    }
    
}

?>
