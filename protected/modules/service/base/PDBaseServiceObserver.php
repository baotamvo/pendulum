<?php

/**
 * Description of PDServiceObserver
 *
 * @author BaoTam Vo
 */
class PDBaseServiceObserver extends CComponent implements ArrayAccess {
    /**
     * the list of currently running services
     * @var CList 
     */
    protected $_services;
    public function __construct() {
        $this->_services = $this->createServices();
    }
    
    public function add($service) {
        $this->_services[] = $service;
    }
    
    public function flush() {
        $this->_services = $this->createServices();
    }
    
    public function execute($directives) {
        if(!is_array($directives)) 
            $directives = array($directives);
        foreach($this->_services as $service) {
            foreach($directives as $directive) {
                $directive->execute($service);
            }
        }
    }
    
    protected function createServices() {
        return new CList();
    }
    
    public function offsetExists($offset) {
        return isset($this->_services[$offset]);
    }

    public function offsetGet($offset) {
        return $this->_services[$offset];
    }

    public function offsetSet($offset, $value) {
        $this->_services[$offset] = $value;
    }

    public function offsetUnset($offset) {
        unset($this->_services[$offset]);
    }
    
    
}

?>
