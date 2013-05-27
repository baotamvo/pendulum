<?php
/**
 * Date: 3/25/13
 * Class: PDApiController
 * Description:
 *
 */
class PDApiController extends PDPrivateController
{
    const PRINT_ERROR = true;
    protected $_response, $_action, $_params;

    public function getRequest() {
        return new CMap($_REQUEST);
    }

    public function getParams() {
        if($this->_params) return $this->_params;
        return $this->_params = new CMap(CJSON::decode($this->getRequest()->itemAt('params')));
    }

    public function getJsonResponse() {
        return $this->_response ? $this->_response : $this->_response = app()->load('service/models/jsonResponse');
    }

    public function getDefaultResponse() {
        return $this->getJsonResponse();
    }

    public function getResponse() {
        return $this->_response ? $this->_response : $this->getDefaultResponse();
    }

    protected function afterAction($action) {
        echo $this->getResponse()->applyEnvironment()->encode();
    }

    protected function setResponse($response) {
        $this->_response = $response;
    }

    protected function disableWebLogRoute() {
        foreach (app()->log->routes as $route) {
            if ($route instanceof CWebLogRoute) {
                $route->enabled = false;
            }
        }
    }

    protected function validateCsrfToken() {
        //TODO: implement
        return true;
    }

    protected function beforeAction($action) {
        $this->disableWebLogRoute();
        if(!$this->validateCsrfToken()) return false;
        return true;
    }

    public function runAction($action) {
        $priorAction=$this->_action;
        $this->_action=$action;
        if($this->beforeAction($action))
        {
            try {
                if($action->runWithParams($this->getActionParams()===false))
                    $this->invalidActionParams($action);
                else
                    $this->afterAction($action);
            } catch(Exception $e) {
                $this->handleException($e);
                $this->afterAction($action);
            }
        } else {
            $this->afterAction($action);
        }
        $this->_action=$priorAction;
    }

    protected function runService($service,$param=array()) {
        return app()->load('service/port')->run($service,$param);
    }

    protected function handleException($e) {
        if(self::PRINT_ERROR) throw $e;
        $response = $this->getDefaultResponse();
        $this->setResponse($response);
        $errorObj = $response->getNewContainer();
        $errorObj->message = $e->getMessage();
        if(onDebug()) $errorObj->trace = $e->getTrace();
        $response->setError('exception',$errorObj);
    }

    protected function map($var,$tokens=array()) {
        return app()->load('service/responseMapper')->map($var,$tokens);
    }
}
