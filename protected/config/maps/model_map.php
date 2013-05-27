<?php

/**
 * Description
 *  
 */

return array(
    'url'=>array(
        'class'=>'app.core.models.PDUrl',
        'construct'=>function($url = null, $label = null,$request=null){
            return new PDUrl($url,$label,$request ? $request : app()->request);
        }
    ),

    'activeDataProvider'=>array(
        'class'=>'CActiveDataProvider',
        'construct'=>function($config) {
            return new CActiveDataProvider(null, $config);
        }
    ),

    'dbExpression'=>array(
        'class'=>'CDbExpression',
        'construct'=>function($exp,$params=array()) {
            return new CDbExpression($exp,$params);
        }
    ),

    'objConfig' => array(
        'class'=>'app.core.models.config.PDObjectConfig',
        'construct'=>function($config) {
            return new PDObjectConfig($config);
        }
    ),

    'error'=>array(
        'class'=>'app.core.models.error.PDError',
        'construct'=>function($errors) {
            return new PDError($errors);
        }
    ),

);
?>
