<?php

/**
 * Description of PDUrl
 *
 * @author BaoTam Vo
 */
class PDUrl extends CModel {
    protected
    $route,
    $params,
    $rawUrl,
    $label,
    $request;

    public function __construct($url,$label,$request) {
        if(is_string($url)) {
            $this->rawUrl = $url;
        } else {
            $this->route  = isset($url[0]) ? $url[0] : '';
            $this->params = isset($url[1]) ? $url[1] : array();
        }
        $this->label = $label;
        $this->request = $request;
    }

    public function attributeNames() {
        return array('route','label','params');
    }

    public function toHtml($htmlOptions = array()) {
        return CHtml::link($this->label,$this->__toString(),$htmlOptions);
    }

    public function addReturnUrl($returnUrl=null) {
        $request   = $this->request;
        $returnUrl = $request->encodeUrl($returnUrl ? $returnUrl : $request->url);
        $this->params[$request->returnUrlParam] = $returnUrl;
        return $this;
    }

    public function __toString() {
        return
            $this->rawUrl ? $this->rawUrl : app()->createAbsoluteUrl($this->route,$this->params);
    }

    public function getRoute() {
        return $this->route;
    }

    public function getLabel() {
        return $this->label;
    }

    public function appendPath($basePath,$appendedPath) {
        if((!$basePath || ($basePath[strlen($basePath)-1] != '/')) && $appendedPath[0] != '/') $basePath .= '/';
        return $basePath.$appendedPath;
    }
}

?>
