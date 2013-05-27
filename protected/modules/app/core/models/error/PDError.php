<?php
/**
 * Date: 3/14/13
 * Class: PDError
 * Description:
 *
 */
class PDError extends CComponent
{
    protected $_errors;
    public $format = '{error}</br>';

    public function __construct($errors) {
       $this->errors = $errors;
    }

    public function setErrors($errors) {
        if(is_array($errors))
            $errors = new CMap($errors);
        $this->_errors = $errors;
    }

    public function getErrors() {
        return $this->_errors;
    }

    public function getString() {
        $str = '';
        foreach($this->errors as $errorArr) {
            foreach($errorArr as $error) {
                $str .= str_replace('{error}',$error,$this->format);
            }
        }
        return $str;
    }

    public function __toString() {
        return $this->getString();
    }
}
