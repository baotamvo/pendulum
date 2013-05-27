<?php
//TODO: provide a list of all built in widgets
return array(
    'activeForm'=>array(
        'class'=>'bootstrap.widgets.TbActiveForm',
        '_init'=>false //whether the widget "init" method should be called on creation
    ),
    'gridView'=>array(
        'class'=>'bootstrap.widgets.TbGridView',
        '_init'=>false,
        'params'=>array('type'=>'striped bordered condensed')
    ),
    'buttonColumn'=>array(
        'class'=>'bootstrap.widgets.TbButtonColumn',
        '_init'=>false,
    )
);