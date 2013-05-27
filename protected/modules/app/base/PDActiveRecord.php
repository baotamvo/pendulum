<?php

    /**
     * Description of PDActiveRecord
     *
     * @author BaoTam Vo
     */
class PDActiveRecord extends CActiveRecord {
    protected
        $_builder;

    private
        $_pk,
        $_updateCriteria;

    public function getResource() {
        $class=get_class($this);
        return $class::model();
    }

    public function addSearchCondition($attribute, $keyword, $escape=true, $operator='AND', $like='LIKE') {
        $this->getDbCriteria()->addSearchCondition($attribute, $keyword, $escape, $operator, $like);
        return $this;
    }

    public function update($attributes = null) {
        // doing nothing new but fix a bug in the return statement.
        if($this->getIsNewRecord())
            throw new CDbException(Yii::t('yii','The record cannot be updated because it is new.'));
        if($this->beforeSave())
        {
            Yii::trace(get_class($this).'.update()','CActiveRecord');
            if($this->_pk===null)
                $this->_pk=$this->getPrimaryKey();
            if(isset($this->oldPrimaryKey))
                $pkToUpdate = $this->getOldPrimaryKey();
            else if(isset($this->primaryKey))
                $pkToUpdate = $this->getPrimaryKey();
            else
                throw new InvalidArgumentException('oldPrimaryKey or primaryKey needed for updating');
            $this->updateByPk($pkToUpdate,$this->getAttributes($attributes), $this->getUpdateCriteria());
            $this->resetUpdateCriteria();
            $this->_pk=$this->getPrimaryKey();
            $this->afterSave();
            return true;
        }
        else
            return false;
    }


    public function getUpdateCriteria() {
        return isset($this->_updateCriteria) ? $this->_updateCriteria : ($this->_updateCriteria = new CDbCriteria);
    }

    public function resetUpdateCriteria() {
        $this->_updateCriteria = new CDbCriteria;
    }

    public function delete() {
        if(!$this->getIsNewRecord())
        {
            Yii::trace(get_class($this).'.delete()','system.db.ar.CActiveRecord');
            if($this->beforeDelete())
            {
                $result = $this->deleteByPk($this->getPrimaryKey());
                $this->afterDelete();
                return $result;
            }
            else
                return false;
        }
        else
            throw new CDbException(Yii::t('yii','The active record cannot be deleted because it is new.'));
    }

    public function addNotIdScope($id) {
        $pkName = $this->tableSchema->primaryKey;
        $as     = $this->tableAlias;
        $this->getDbCriteria()->mergeWith(array(
            'condition'=>$as.'.'.$pkName.' <> :'.$as.'_id',
            'params'=>array(':'.$as.'_id'=>"$id")
        ));
        return $this;
    }

    public function addIdsScope($ids) {
        $pkName = $this->tableSchema->primaryKey;
        $this->getDbCriteria()->addInCondition($pkName,$ids);
        return $this;
    }

    public function addNotSelfScope($model) {
        return $this->addNotIdScope($model->primaryKey);
    }

    public function getNew($attributes=array(),$params=array()) {
        return $this->instantiate($attributes,$params);
    }

}

?>
