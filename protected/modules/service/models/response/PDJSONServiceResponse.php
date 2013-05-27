<?php
Yii::import('service.base.PDObjectiveResponse');
/**
 * Description of PDResponseObject
 *
 * @author BaoTam Vo
 */
class PDJSONServiceResponse extends PDObjectiveResponse{
    
    protected $_responseContainer;
    
    public function __construct($responseContainer = null) {
        if(!$responseContainer)
            $responseContainer = new stdClass;
        $this->setResponseContainer($responseContainer);
    }
    
    public function setType($type) {
        $this->getResponseContainer()->type = $type;
    }
    
    public function getType() {
        return $this->getResponseContainer()->type;
    }

    public function assignContent($obj) {
        $this->setContentContainer($this->toObj($obj));
    }

    protected function toObj($array){
        if(is_array($array)) {
            $obj= new stdClass();
            foreach ($array as $k=> $v) {
                if (is_array($v)){
                    $v = $this->toObj($v);
                }
                $obj->{strtolower($k)} = $v;
            }
            return $obj;
        }
        return $array;
    }

    public function setContent($key, $message) {
        $this->getContentContainer()->$key = $message;
    }
    
    public function getContent($key) {
        return $this->getContentContainer()->$key;
    }

    public function setError($key,$message) {
        $this->getErrorContainer()->$key = $message;
    }

    public function setErrors($errors) {
        foreach($errors as $key=>$message) {
            $this->setError($key,$message);
        }
    }

    public function getError($key) {
        return $this->getErrorContainer()->$key;
    }

    public function getErrorContainer() {
        return isset($this->_responseContainer->error) ?
            $this->_responseContainer->error : $this->_responseContainer->error = $this->getNewContainer();
    }

    public function getNewContainer($var = null) {
        if($var) return (object)$var;
        return new stdClass;
    }

    protected function getContentContainer() {
        return isset($this->_responseContainer->content) ?
            $this->_responseContainer->content : $this->_responseContainer->content = $this->getNewContainer();
    }

    protected function setContentContainer($content) {
        $this->_responseContainer->content = $content;
    }

    public function getResponseContainer() {
        return $this->_responseContainer;
    }

    public function error() {
        return $this->getErrorContainer();
    }

    public function content() {
        return $this->getErrorContainer();
    }

    public function setResponseContainer($responseContainer) {
        $this->_responseContainer = $responseContainer;
    }

    public function encode() {
        return CJSON::encode($this->getResponseContainer());
    }
    
    public function getFormat() {
        return 'json';
    }

    public function hasErrors() {
        return (bool)count((array)$this->getErrorContainer());
    }

    public function applyEnvironment() {
        header('Content-Type: application/json; charset=UTF8');
        if($this->hasErrors())
            header('HTTP/1.1 500 Internal Server Error', true, 500);

        return $this;
    }
}

?>
