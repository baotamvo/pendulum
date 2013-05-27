<?php
class PDAccountTypeManager extends CBehavior
{
    public function getTypeCode() {
        return $this->owner->type->code;
    }
}
