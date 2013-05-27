<?php
/**
 * Date: 2/3/13
 * Class: PDHtml
 * Description:
 *
 */
class PDHtml extends CApplicationComponent {
    public function __call($name,$params) {
        try {
            return parent::__call($name,$params);
        } catch(CException $e) {
            $func = array('CHtml',$name);
            if(is_callable($func))
                return call_user_func_array($func,$params);
            throw $e;
        }
    }

    public function __isset($name) {
        if(!($result = parent::__isset($name))) {
            return isset(CHtml::$$name);
        }
        return $result;
    }

    public function __unset($name) {
        if(!($result = parent::__isset($name))) {
            return isset(CHtml::$$name);
        }
        return $result;
    }

    public function __set($name,$val) {
        try {
            return parent::__set($name,$val);
        } catch(CException $e) {
            if(isset(CHtml::$$name))
                return CHtml::$$name = $val;
            throw $e;
        }
    }
}
