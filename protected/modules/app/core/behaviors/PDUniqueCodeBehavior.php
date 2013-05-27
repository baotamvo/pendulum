<?php
class PDUniqueCodeBehavior extends CBehavior
{
    public function addCodeScope($code) {
        $alias = $this->owner->getTableAlias();
        $this->owner->getDbCriteria()->mergeWith(array(
            'condition'=>"{$alias}.code=:{$alias}_code",
            'params'=>array("{$alias}_code"=>"$code")
        ));
        return $this->owner;
    }

    public function validateCodeRegex($attr,$params=array()) {
        if($code = $this->owner->$attr) {
            $regex = '/\w+/';
            $message = 'Only letters, digits, and underscores "_" are allowed';
            if(!preg_match($regex,$code))
                $this->owner->addError($attr,$message);

        }
    }

}
