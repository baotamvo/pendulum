<?php

/**
 * Description of PDBaseLogicRuleMatcher
 *
 * @author BaoTam Vo
 */
abstract class PDBaseLogicRuleMatcher extends CComponent {
    
    public function __construct($matchingMap) {
        $this->setMatchingMap($matchingMap);
    }
    
    abstract public function setMatchingMap($matchingMap);
    
    abstract public function getDependableAttribute($dependentAttribute);
    
    abstract public function getDependentAttribute($dependableAttribute);
    
    abstract public function getDependentAttributes();
    
    abstract public function getDependableAttributes();
}

?>
