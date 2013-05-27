<?php
/**
 * Date: 3/14/13
 * Class: PDObjectConfig
 * Description:
 *
 */
class PDObjectConfig extends CComponent
{
    protected $configArr;
    public function __construct($configArr = array()) {
        $this->configArr = new CMap($configArr);
    }

    public function apply($obj) {
        foreach($this->configArr as $property=>$value) {
            $obj->$property = $value;
        }
    }
}
