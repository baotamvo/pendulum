<?php

/**
 * Description of PDConfigManager
 *
 * @author BaoTam Vo
 */
class PDConfigLocator extends CApplicationComponent {
    public $configs;

    public function get($id) {
        return require($this->parseConfig(isset($this->configs[$id]) ?
            $this->configs[$id] :
            $id.'.config.conf'
        ));
    }


    protected function parseConfig($alias) {
        return Yii::getPathOfAlias($alias).'.php';
    }
}

?>
