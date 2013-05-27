<?php

/**
 * Description of PDBaseServiceResponse
 *
 * @author BaoTam Vo
 */
abstract class PDBaseServiceResponse extends CComponent {
    
    /**
     * encode the response to send to client 
     */
    abstract protected function encode();
    
    abstract public function getFormat();


    public function __toString() {
        return $this->encode();
    }
}

?>
