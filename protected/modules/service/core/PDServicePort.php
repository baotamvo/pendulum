<?php
/**
 * Date: 2/24/13
 * Class: PDServicePort
 * Description:
 *
 */
class PDServicePort extends CApplicationComponent
{
    public $exception = false;

    public function run($service,$params=array()) {
        if(method_exists($params,'toArray'))
            $params = $params->toArray();
        $service->attributes = $params;
        $this->beforeRun();
        if($service->run()) {
            $transaction = $service->beginTransaction();
            try {
                $transaction->commit();
                $result = true;
            }catch(Exception $e) {
                $this->exception = $e;
                $transaction->rollback();
                $this->processError($e);
                $result = false;
            }

            return $result;
        }
        return false;
    }

    protected function beforeRun() {
        $this->exception = false;
    }

    protected function processError($e) {
        if(onDebug()) throw $e;
        Yii::log('Error in service: '.get_class($service)."\r\n".$e->getMessage()."\r\n".$e->getTraceAsString(),'service-error','service');
    }
}
