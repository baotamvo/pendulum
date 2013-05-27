<?php
/**
 * Date: 2/24/13
 * Class: PDServiceTransaction
 * Description:
 *
 */
class PDServiceTransaction extends CComponent
{
    protected $service, $dbTransaction, $_active;

    public function __construct($service) {
        $this->dbTransaction = app()->db->beginTransaction();
        $this->service = $service;
        $this->setActive(true);
    }

    public function commit() {
        $this->checkActive();
        $this->service->commit();
        $this->dbTransaction->commit();
        $this->setActive(false);
    }

    public function getActive() {
        return $this->_active;
    }

    protected function setActive($active) {
        $this->_active = $active;
    }

    public function rollback() {
        $this->checkActive();
        $this->dbTransaction->rollback();
        $this->service->rollback();
        unset($this->dbTransaction);
        $this->setActive(false);
    }

    protected function checkActive() {
        if(!$this->active)
            throw new PDServiceException('Transaction is inactive.');
    }
}
