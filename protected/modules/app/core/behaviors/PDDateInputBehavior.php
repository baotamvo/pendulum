<?php
class PDDateInputBehavior extends CBehavior
{

    public
        $in = 'MM/dd/yyyy',
        $out = 'yyyy-MM-dd',
        $attachEvents = false,
        $dateAttrs = array();

    public function events() {
        if(!$this->attachEvents) return array();
        return array(
            'onBeforeSave'=>'beforeSave',
            'onAfterSave'=>'afterSave',
            'onAfterFind'=>'afterFind'
        );
    }

    public function formatDateOut($attr) {
        return $this->owner->$attr ?
            $this->format($this->owner->$attr,$this->in,$this->out)
            : null;
    }

    public function formatDateIn($attr,$date=''){
        if(!$date && $this->owner->$attr)
            $date = $this->owner->$attr;
        if($date)
            $this->owner->$attr = $this->format($date,$this->out,$this->in);
    }

    public function format($date,$from,$to) {
        $timestamp = CDateTimeParser::parse($date, $from);
        if(!$timestamp) $timestamp = CDateTimeParser::parse($date,$to);
        if(!$timestamp) throw new CException('Date format of '.$date.' not recognized');
        return $this->timestampToFormat($timestamp,$to);
    }

    public function timestampToFormat($timestamp,$toFormat) {
        return app()->dateFormatter->format(
            $toFormat,
            $timestamp
        );
    }

    public function timestampToSqlDateTime($timestamp) {
        return $this->timestampToFormat($timestamp,'yyyy-MM-dd hh:mm:ss');
    }

    public function beforeSave() {
        foreach($this->dateAttrs as $dateAttr)
            $this->owner->$dateAttr = $this->formatDateOut($dateAttr);
    }

    public function afterSave() {
        foreach($this->dateAttrs as $dateAttr)
            $this->formatDateIn($dateAttr);
    }

    public function afterFind() {
        foreach($this->dateAttrs as $dateAttr)
            $this->formatDateIn($dateAttr);
    }

}
