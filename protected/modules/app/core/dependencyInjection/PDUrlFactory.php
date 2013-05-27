<?php
Yii::import('PDObjectFactory');
/**
 * Description of PDUrlMap
 *
 * @author BaoTam Vo
 */
class PDUrlFactory extends PDObjectFactory {
    public function build($declaration, $runtimeParams = array()) {
        if(!isset($declaration['url'])) {
            return parent::build($declaration, $runtimeParams);
        }
        
        $params = array();
        if(isset($declaration['url'])) {
            $params['url'] = $declaration['url'];
        }
        if(isset($declaration['label']))
            $params['label'] = $declaration['label'];
        
        return app()->models->get('url',$params);
    }
}

?>
