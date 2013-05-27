<?php
/**
 * Date: 3/25/13
 * Class: PDResponseMapper
 * Description:
 *
 */
class PDResponseMapper extends CApplicationComponent
{
    public function map($var,$tokens = array()) {
        if(!count($var)) {
            return array();
        } elseif($var instanceof Countable || is_array($var)) {
            $objs = array();
            foreach($var as $key => $_var) {
                //check if key is an integer
                if(is_int($key)) {
                    $objs[$key] = $this->handleTokens($_var,$tokens);
                } else {
                    $objs[] = $this->handleTokens($_var,$tokens);
                }
            }
            return $objs;
        } else {
            return $this->handleTokens($var,$tokens);
        }
    }

    protected function handleTokens($object,$tokens) {
        $obj = array();
        foreach($tokens as $token=>$subTokens) {
            if(is_int($token)) {
                $property = $subTokens;
                if((string)$property=='*') {
                    foreach($object->attributes as $attrName=>$value) {
                        $obj[$attrName] = $value;
                    }
                } else {
                    $obj[$property] = $this->evalProperty($object,$property);
                }
            } else {
                $property = $token;
                $_object  = $this->evalProperty($object,$property);
                $obj[$property] = $this->map($_object,$subTokens);
            }
        }
        return $obj;
    }

    protected function evalProperty($object,$prop) {


        if(method_exists($object,'hasProperty') && $object->hasProperty($prop))
            return $object->{$prop};

        if(property_exists($object,$prop))
            return $object->{$prop};

        if(isset($object->{$prop})) return $object->{$prop};

        $object = (array)$object;
        if(isset($object[$prop])) return $object[$prop];

        return null;
    }
}
