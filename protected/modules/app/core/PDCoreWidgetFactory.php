<?php
/**
 * Date: 2/20/13
 * Class: PDCoreWidgetFactory
 * Description:
 *
 */
class PDCoreWidgetFactory extends CWidgetFactory
{
    public function createWidget($owner,$widget,$properties=array()) {
        if(is_string($widget)) {
            $className=Yii::import($widget,true);
            $widget=new $className($owner);
        } else {
            $className = get_class($widget);
        }

        if(isset($this->widgets[$className]))
            $properties=$properties===array() ? $this->widgets[$className] : CMap::mergeArray($this->widgets[$className],$properties);

        if($this->enableSkin)
        {
            if($this->skinnableWidgets===null || in_array($className,$this->skinnableWidgets))
            {
                $skinName=isset($properties['skin']) ? $properties['skin'] : 'default';
                if($skinName!==false && ($skin=$this->getSkin($className,$skinName))!==array())
                    $properties=$properties===array() ? $skin : CMap::mergeArray($skin,$properties);
            }
        }


        foreach($properties as $name=>$value)
            $widget->$name=$value;
        return $widget;
    }
}
