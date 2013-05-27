<?php
/**
 * Date: 3/19/13
 * Class: PDObjectMapper
 * Description:
 *
 */
class PDObjectMapper extends CApplicationComponent
{
    public function get($uri,$params=array()) {
        $tokens = $this->getTokens($uri);
        $object = app();
        $tokenCount = count($tokens);
        foreach($tokens as $idx=>$token) {
            if(method_exists($object,'_locator_get')) {
                if($tokenCount == $idx+1)
                    return $object->_locator_get($token,$params);
                $object = $object->_locator_get($token);
            }
            elseif(method_exists($object,'getModule') && ($module = $object->getModule($token)))
                $object = $module;
            else
                $object = $object->$token;
        }
        return $object;
    }

    public function getClass($uri) {
        $tokens = $this->getTokens($uri);
        $object = app();
        $tokenCount = count($tokens);
        foreach($tokens as $idx=>$token) {
            if(method_exists($object,'_locator_get_class') && ($tokenCount == $idx+1))
                $object = $object->_locator_get_class($token);
            elseif(method_exists($object,'getModule') && ($module = $object->getModule($token)))
                $object = $module;
            else
                $object = $object->$token;
        }
        return $object;
    }

    protected function getTokens($uri) {
        return preg_split("/[\s\/]+/",trim($uri));
    }
}
