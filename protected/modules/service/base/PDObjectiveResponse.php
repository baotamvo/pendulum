<?php
Yii::import('service.base.PDBaseServiceResponse');
/**
 * Description of PDBaseTypeContentResponse
 *
 * @author BaoTam Vo
 */
abstract class PDObjectiveResponse extends PDBaseServiceResponse{
    abstract function getType();
    abstract function setType($type);
    abstract function setContent($key,$value);
    abstract function getContent($key);
    abstract function setError($key,$value);
    abstract function getError($key);
}

?>
