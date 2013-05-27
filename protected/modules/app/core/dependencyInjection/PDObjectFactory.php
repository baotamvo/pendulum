<?php

class PDObjectFactory extends CApplicationComponent {

    public $defaultClass = 'PDObjectLocator';

    public function build($declaration, $runtimeParams = array()) {

        $this->parseImport($declaration);
        $class  = $this->parseClass($declaration);
        $result = $this->parseConstruct($declaration,$runtimeParams,$class);

        return $result;
    }

    public function getClass($declaration, $runtimeParams = array()) {
        if($class = $this->parseClass($declaration)){
            $this->parseImport($declaration);
            return $class;
        }
        return get_class($this->parseConstruct($declaration,$class));
    }

    protected function parseImport($declaration) {
        if(isset($declaration['import']))
            $this->import($declaration['import']);
        else
            return false;
    }

    protected function parseConstruct($declaration,$runtimeParams, $class) {
        if(is_array($declaration) && isset($declaration['construct'])) {
            $result = $this->construct($declaration['construct'],$runtimeParams);
        } else {
            $class  = $class ? $class : $this->defaultClass;
            $result = new $class;
        }
        return $result;
    }

    protected function parseClass($declaration) {

        if(is_string($declaration))
            $class = $declaration;
        elseif(isset($declaration['class']))
            $class = $declaration['class'];

        if(isset($class))
            return Yii::import($class);

        return false;
    }

    protected function construct($construct,$runtimeParams) {
        $constructFunc = new ReflectionFunction($construct);
        $definedParams = $constructFunc->getParameters();
        $invokedParams = array();
        foreach($definedParams as $param) {
            if(isset($runtimeParams[$param->getName()]))
                $invokedParams[$param->getPosition()] = $runtimeParams[$param->getName()];
            elseif($param->isOptional())
                $invokedParams[$param->getPosition()] = $param->getDefaultValue();
            else
                throw new InvalidArgumentException("{$param->getName()} is required in construct function");
        }
        $result = $constructFunc->invokeArgs($invokedParams);
        return $result;
    }


    protected function import($import) {
        if(is_array($import))
            foreach($import as $alias)
                Yii::import($alias);
        elseif(is_callable($import))
            $import();
        else
            Yii::import($import);
    }

}

?>
