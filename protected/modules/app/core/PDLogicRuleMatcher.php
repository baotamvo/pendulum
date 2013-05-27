<?php

/**
 * Description of PDLogicRuleAttrbiuteMatcher
 *
 * @author BaoTam Vo
 */
class PDLogicRuleMatcher extends PDBaseLogicRuleMatcher {
    
    protected $_dependentToDependable;
    protected $_dependableToDependent;
    
    public function __construct($matchingMap = array()) {
        $this->setMatchingMap($matchingMap);
    }
    
    public function getDependableAttribute($dependentAttribute) {
        if(!isset($this->_dependentToDependable[$dependentAttribute])) 
            return false;
        return $this->_dependentToDependable[$dependentAttribute];
    }
    
    public function getDependentAttribute($dependableAttribute) {
        if(!isset($this->_dependableToDependent[$dependableAttribute])) 
            return false;
        return $this->_dependableToDependent[$dependableAttribute];
    }
    
    public function setMatchingMap($matchingMap) {
        foreach($matchingMap as $dependentAttr => $dependableAttr) {
            if(isset($this->_dependableToDependent[$dependableAttr]))
                throw new InvalidArgumentException("duplicate dependable atrribute \"$dependableAttr\"");
            $this->_dependableToDependent[$dependableAttr] = $dependentAttr;
            $this->_dependentToDependable[$dependentAttr]  = $dependableAttr;
        }
    }
    
    public function getDependentAttributes() {
        return array_keys($this->_dependentToDependable);
    }
    
    public function getDependableAttributes() {
        return array_keys($this->_dependableToDependent);
    }
    
    public function flushMap() {
        unset($this->_dependableToDependent);
        unset($this->_dependableToDependent);
    }
}

?>
