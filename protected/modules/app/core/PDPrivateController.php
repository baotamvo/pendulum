<?php
/**
 * Date: 3/19/13
 * Class: PDPrivateController
 * Description:
 *
 */
class PDPrivateController extends PDController
{
    public function filters()
    {
        return new CList(array(
            'accessControl',
        ));
    }

    public function accessRules()
    {
        return new CMap(array(
            array('deny',
                'users'=>array('?'),
            ),
        ));
    }

    public function getUser() {
        return user()->user;
    }
}
