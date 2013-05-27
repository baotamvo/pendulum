<?php
class PDAvailabilityBehavior extends CBehavior
{
    protected $_availabilityAttr = 'enabled';
    public function __construct($availabilityAttr='') {
        if($availabilityAttr)
            $this->_availabilityAttr = $availabilityAttr;
    }
    public function addIsEnabledScope($isEnabled=1) {
        $alias = $this->owner->getTableAlias();
        $attr = $this->_availabilityAttr;
        $this->owner->getDbCriteria()->mergeWith(array(
            'condition'=>"{$alias}.{$attr}=:{$alias}_{$attr}",
            'params'=>array("{$alias}_{$attr}"=>"$isEnabled")
        ));
        return $this->owner;
    }
}
