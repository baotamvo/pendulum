<?php

/**
 * Description of PDFunctionManager
 *
 * @author BaoTam Vo
 */
class PDFunctionManager extends CApplicationComponent {
    public $files = array();
    
    
    public function init() {
        foreach($this->files as $file) {
            require_once Yii::getPathOfAlias($file).'.php';
        }
    }
}

?>
