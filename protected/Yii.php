<?php
/**
 * Date: 3/1/13
 * Class: Yii
 * Description:
 *
 */
class Yii extends YiiBase
{
    public static function createComponent($config) {
        if(is_string($config))
        {
            $type=$config;
            $config=array();
        }
        elseif(isset($config['class']))
        {
            $type=$config['class'];
            unset($config['class']);
        }
        else
            throw new CException(Yii::t('yii','Object configuration must be an array containing a "class" element.'));

        if(!is_object($type)) {
            if(!class_exists($type,false))
                $type=Yii::import($type,true);

            if(($n=func_num_args())>1)
            {
                $args=func_get_args();
                if($n===2)
                    $object=new $type($args[1]);
                elseif($n===3)
                    $object=new $type($args[1],$args[2]);
                elseif($n===4)
                    $object=new $type($args[1],$args[2],$args[3]);
                else
                {
                    unset($args[0]);
                    $class=new ReflectionClass($type);
                    // Note: ReflectionClass::newInstanceArgs() is available for PHP 5.1.3+
                    // $object=$class->newInstanceArgs($args);
                    $object=call_user_func_array(array($class,'newInstance'),$args);
                }
            }
            else
                $object=new $type;
        } else
            $object=$type;


        foreach($config as $key=>$value)
            $object->$key=$value;

        return $object;
    }
}
