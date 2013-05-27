<?php

/**
 * Description of LogicRuleAdaptor
 * A LogicRuleAdaptor adapt a model's validation rules to another's
 * to minimize coupling between their attributes
 * @author BaoTam Vo
 * @property PDLogicRuleMatcher $logicRuleMatcher
 * @property CModel $dependable
 */
class PDLogicRuleAdapter extends CComponent {
    protected $_dependable;
    
    /**
     *
     * @var PDLogicRuleMatcher
     */
    protected $_logicRuleMatcher;
    
    
    public function __construct($logicRuleMatcher = null) {
        if($logicRuleMatcher)
            $this->setLogicRuleMatcher($logicRuleMatcher);
    }
    
    public function setLogicRuleMatcher($matcher) {
        $this->_logicRuleMatcher = $matcher;
    }
    
    public function getLogicRuleMatcher() {
        return $this->_logicRuleMatcher;
    }
    
    public function setDependable($dependable) {
        $this->_dependable = $dependable;
    }
    
    public function getDependable() {
        return $this->_dependable;
    }
    
    
    public function getValidatorList($dependentAttrs = null) {
        if(!$dependentAttrs) {
            $dependentAttrs = $this->_logicRuleMatcher->getDependentAttributes();
        }
        
        $dependableValidatorList = $this->_dependable->getValidatorList();
        $dependentValidatorList  = array();
        
        foreach($dependableValidatorList as $dependableValidator) {
            $validatedAttrs          = $dependableValidator->attributes;
            $validatedDependentAttrs = array();
            foreach($validatedAttrs as $validatedAttr) {
                $validatedDependentAttr = $this->_logicRuleMatcher->getDependentAttribute($validatedAttr);
                if($validatedDependentAttr && array_search($validatedDependentAttr, $dependentAttrs) !== false) {
                    $validatedDependentAttrs[] = $validatedDependentAttr; 
                }
            }
            
            if(!empty($validatedDependentAttrs)) {
                $dependentValidator = clone $dependableValidator;
                $dependentValidator->attributes = $validatedDependentAttrs;
                $dependentValidatorList[] = $dependentValidator;
            }
        }
        
        return $dependentValidatorList;
    }
    
    /**
     * 
     * @param array $attributes the dependent attributes that needs to be validated,
     *  defaults to null meaning validate all dependent attributes
     */
    public function validate($dependentAttrs=null) {
        if(!$dependentAttrs) {
            $toBeValidatedAttrs = $this->_logicRuleMatcher->getDependableAttributes();
        }
        else {
            $toBeValidatedAttrs = array();
            foreach($dependentAttrs as $dependentAttr) {
                $toBeValidatedAttrs[] = $this->_logicRuleMatcher->getDependableAttribute($dependentAttr);
            }
        }
        
        return $this->_dependable->validate($toBeValidatedAttrs);
    }
    
    /**
     * Pass in an assoc array of dependentAttr => value to set the attributes of the dependable model.
     * All depedentAttr not declared will be ignored.
     * @param array $dependentAttrs 
     */
    public function setAttributes($dependentAttrs) {
        foreach($dependentAttrs as $dependentAttr => $dependentAttrValue) {
            $dependableAttr = $this->_logicRuleMatcher->getDependableAttribute($dependentAttr);
            if($dependableAttr) {
                $this->_dependable->setAttribute($dependableAttr, $dependentAttrValue);
            }
        }
    }
    
    
    /**
     * Pass in an array of dependentAttrs to get an assoc array of dependentAttr => dependableAttrvalue from the dependable model
     * @param array $dependentAttrs 
     * @return array dependentAttr => dependableAttrvalue
     */
    public function getAttributes($dependentAttrs = null) {
        if(empty($dependentAttrs)) {
            $dependentAttrs = $this->_logicRuleMatcher->getDependentAttributes();
        }
        
        $dependentAttrsToValues = array();
        foreach($dependentAttrs as $dependentAttr) {
            $dependableAttr = $this->_logicRuleMatcher->getDependableAttribute($dependentAttr);
            if($dependableAttr) {
                $dependentAttrsToValues[$dependentAttr] = $this->_dependable->getAttribute($dependableAttr);
            }
        }
        return $dependentAttrsToValues;
    }
    
    public function getErrors($dependentAttrs = null) {
        if(!$dependentAttrs) {
            $dependableAttrs = $this->_logicRuleMatcher->getDependableAttributes();
        }
        else {
            $dependableAttrs = array();
            foreach($dependentAttrs as $dependentAttr) {
                $dependableAttrs[] = $this->_logicRuleMatcher->getDependableAttribute($dependentAttr);
            }
        }
        $origErrors     = $this->_dependable->getErrors();
        $filteredErrors = array();
        foreach($origErrors as $origAttrWithError => $origAttrErrors) {
            if($dependentAttrWithError = $this->_logicRuleMatcher->getDependentAttribute($origAttrWithError)) {
                $filteredErrors[$dependentAttrWithError] = $origAttrErrors;
                continue;
            }
            
            $filteredErrors[] = $origAttrErrors;
        }
        return $filteredErrors;
    }
    
    public function flush() {
        unset($this->_dependable);
        unset($this->_logicRuleMatcher);
    }
}

?>
