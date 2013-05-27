<?php
/**
 * Date: 1/30/13
 * Class: PDWidgetFactory
 * Description:
 *
 */
class PDWidgetFactory extends PDObjectFactory
{
    public $widgetFactoryId = 'widgetFactory';

    public function build($declaration, $runtimeParams = array()) {
        $declaration = CMap::mergeArray(array('_init'=>true),$declaration, $runtimeParams);
        $params = isset($declaration['params']) ? $declaration['params'] : array();
        if(isset($declaration['construct'])) {
            $widget = parent::build($declaration,$runtimeParams);
            foreach($params as $property=>$param) {
                $widget->$property = $param;
            }
        } else {
            $owner  = isset($declaration['owner']) ? $declaration['owner'] : app()->controller;
            $class  = $declaration['class'];
            $widget = $this->getWidgetFactory()->createWidget($owner,$class,$params);
        }
        if($declaration['_init'])
            $widget->init();
        return $widget;
    }

    protected function getWidgetFactory() {
        return app()->load($this->widgetFactoryId);
    }
}

