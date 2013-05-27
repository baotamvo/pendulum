<?php

/**
 * Description of PDWebApplication
 *
 * @author BaoTam Vo
 */
class PDWebApplication extends CWebApplication {

    protected $cachedAliases = array();

    public function __construct($config = null) {
        if(is_string($config)) {
            $config=require($config);
        }
        parent::__construct($config);
    }

    public function getServices() {
        return $this->getModule('service')->services;
    }

    public function load($uri,$params=array()) {
        return $this->mapper->get($uri,$params);
    }

    public function import($uri) {
        $alias = preg_replace('/[\s\/]+/','_',$uri);
        if(!isset($this->cachedAliases[$alias])) {
            $this->cachedAliases[$alias] = true;
            $class = $this->getClass($uri);
            if(!class_alias($alias,$class))
                throw new CException('Cannot create alias '.$uri);
        }
    }

    public function getClass($uri) {
        return $this->mapper->getClass($uri);
    }

    protected function getHomeUrlRoute() {
        return $this->load('urls/homePage')->route;
    }

    public function createController($route,$owner=null)
    {
        if($owner===null)
            $owner=$this;
        if(($route=trim($route,'/'))==='') {
            if(method_exists($owner,'getHomeUrlRoute') && ($homeUrl = $owner->getHomeUrlRoute())) {
                return $this->createController($homeUrl,$owner);
            }
            $route=$owner->defaultController;
        }
        $caseSensitive=$this->getUrlManager()->caseSensitive;

        $route.='/';
        while(($pos=strpos($route,'/'))!==false)
        {
            $id=substr($route,0,$pos);
            if(!preg_match('/^\w+$/',$id))
                return null;
            if(!$caseSensitive)
                $id=strtolower($id);
            $route=(string)substr($route,$pos+1);
            if(!isset($basePath))  // first segment
            {
                if(isset($owner->controllerMap[$id]))
                {
                    return array(
                        Yii::createComponent($owner->controllerMap[$id],$id,$owner===$this?null:$owner),
                        $this->parseActionParams($route),
                    );
                }
                if(($module=$owner->getModule($id))!==null)
                    return $this->createController($route,$module);

                $basePath=$owner->getControllerPath();
                $controllerID='';
            }
            else
                $controllerID.='/';
            $className=ucfirst($id).'Controller';
            $classFile=$basePath.DIRECTORY_SEPARATOR.$className.'.php';

            if($owner->controllerNamespace!==null)
                $className=$owner->controllerNamespace.'\\'.$className;

            if(is_file($classFile))
            {
                if(!class_exists($className,false))
                    require($classFile);
                if(class_exists($className,false) && is_subclass_of($className,'CController'))
                {
                    $id[0]=strtolower($id[0]);
                    return array(
                        new $className($controllerID.$id,$owner===$this?null:$owner),
                        $this->parseActionParams($route),
                    );
                }
                return null;
            }
            $controllerID.=$id;
            $basePath.=DIRECTORY_SEPARATOR.$id;
        }
    }
}

?>
