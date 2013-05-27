<?php

/**
 * Description of PDObjectLocator
 *
 * @author BaoTam Vo
 */
class PDObjectLocator extends CApplicationComponent {
    public
        $objectFactoryId = 'objectFactory';
    protected
        $_objects = array();

    public function get($id, $params = array()) {
        Yii::beginProfile('objLocator_get');
        if(!isset($this->objects[$id]))
            throw new InvalidArgumentException('Object with id "'.$id.'" not found');
        Yii::endProfile('objLocator_get');

        return $this->getObjectFactory()->build($this->objects[$id], $params);
    }

    public function _locator_get($id,$params=array()) {
        return $this->get($id,$params);
    }
    public function _locator_get_class($id,$params=array()) {
        return $this->getClass($id,$params);
    }

    public function getClass($id, $params = array()) {
        if(!isset($this->objects[$id]))
            throw new InvalidArgumentException('Object with id "'.$id.'" not found');
        return $this->getObjectFactory()->getClass($this->objects[$id], $params);
    }
    public function getAll() {
        $objectIds = $this->objects->keys;
        $results   = array();
        foreach($objectIds as $id) {
            $results[$id] = $this->get($id);
        }

        return $results;
    }

    public function setObjects($objects) {
        $this->_objects = $objects;
    }
    public function setDefaultParams($params) {
        $this->_defaultParams = $params;
    }
    protected function getObjects() {
        if(is_string($this->_objects))
            return $this->_objects = new CMap(require($this->_objects));
        if(is_array($this->_objects))
            return $this->_objects = new CMap($this->_objects);
        return $this->_objects;
    }

    protected function getObjectFactory() {
        return app()->load($this->objectFactoryId);
    }
}

?>
