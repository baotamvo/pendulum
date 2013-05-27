<?php
class PDWidget extends CWidget {
    protected static $_viewPaths;
    protected
        $_children,
        $_model,
        $_view,
        $_owner;


    public function __construct($owner=null,$model=null) {
        $this->owner = $owner;
        $this->model = $model;
        $this->_children = new CMap;
        $this->afterConstruct();
    }

    public function setOwner($owner) {
        $this->_owner = $owner;
    }

    public function getOwner() {
        if(!$this->_owner) $this->_owner = $this->getController();
        return $this->_owner;
    }

    protected function afterConstruct() {
        return;
    }

    public function getTemplateHintEnabled() {
        return false;
    }

    public function applyTemplateHint($output) {
        return '<div class="template-hint">'.$output.'</div>';
    }

    public function setModel($model) {
        $this->_model = $model;
    }
    public function getModel() {
        return $this->_model;
    }
    public function setView($view) {
        $this->_view = $view;
    }

    public function getView() {
        return $this->_view;
    }

    public function setChildren($children) {
        foreach($children as $id=>$child) {
            $this->setChild($id,$child);
        }
    }

    public function addChildren($children) {
        $this->children->mergeWith($children);
    }

    public function addChild($id, $child, $override=false) {
        if($override) {
            if($this->children->contains($id))
                throw new CException('A child widget with id "'.$id.'" already exists.');
            $this->setChild($id,$child);
        }
        $this->children->add($id,$child);
    }

    public function setChild($id,$child) {
        $children = $this->children;
        if(is_string($child))
            $children[$id]=app()->load($child);
        elseif(is_callable($child))
            $children[$id]=$child();
        else
            $children[$id]=$child;
    }

    public function getChildren() {
        return $this->_children;
    }

    public function getChild($key) {
        return $this->getChildren()->itemAt($key);
    }

    public function run($return=false) {
        try{
            return $this->render(null,null,$return);
        } catch(Exception $e) {
            echo $e;
        }
    }

    public function runChild($name,$return=false) {
        if($child = $this->getChild($name)) {
            return $child->run($return);
        }
    }

    public function render($view=null, $data=null, $return=false) {
        if(!$view && $this->view) $view = $this->view;
        $ouput = parent::render($view,$data,$return);
        if($this->getTemplateHintEnabled())
            $ouput = $this->applyTemplateHint($ouput);
        return $ouput;
    }

    public function getViewPath($checkTheme=false)
    {
        $className=get_class($this);
        if(isset(self::$_viewPaths[$className]))
            return self::$_viewPaths[$className];
        else
        {
            if($checkTheme && ($theme=Yii::app()->getTheme())!==null)
            {
                $path=$theme->getViewPath().DIRECTORY_SEPARATOR;
                if(is_dir($path))
                    return self::$_viewPaths[$className]=$path;
            }

            $class=new ReflectionClass($className);
            return self::$_viewPaths[$className]=dirname($class->getFileName()).DIRECTORY_SEPARATOR.'views';
        }
    }
}