<?php

/**
 * Description
 *
 */
return array(

    'registration'=>array(
        'class'=>'service.services.PDRegistrationService',
        'construct'=>function($newUser=null,$newAirline=null) {
            $newUser    = $newUser ? $newUser : app()->getModule('account')->models->get('user');
            $newAirline = $newAirline ? $newAirline : app()->getModule('airline')->models->get('airline');

            return new PDRegistrationService(
                $newUser,
                $newAirline,
                new PDLogicRuleAdapter(new PDLogicRuleMatcher(array(
                    'username'=>'user_login',
                    'password'=>'user_pass',
                    'name'=>'display_name',
                    'email'=>'user_email',
                ))),
                new PDLogicRuleAdapter(new PDLogicRuleMatcher(array(
                    'name'=>'name',
                    'email'=>'email'
                )))
            );
        }
    ),

    'addJobPosition'=>array(
        'class'=>'jobPosition.services.PDJobPositionAddService',
        'construct'=>function($newJobPosition=null, $user=null) {
            $newJobPosition = $newJobPosition ? $newJobPosition : app()->getModule('jobPosition')->models->get('jobPosition');
            $user     = $user ? $user : user()->airline;
            return new PDJobPositionAddService(
                $user,
                $newJobPosition,
                new PDLogicRuleAdapter(new PDLogicRuleMatcher(array(
                    'name'=>'name',
                    'description'=>'description'
                )))
            );
        }
    ),

    'editJobPosition'=>array(
        'class'=>'jobPosition.services.PDJobPositionEditService',
        'construct'=>function($jobPosition) {
            return new PDJobPositionEditService(
                $jobPosition,
                new PDLogicRuleAdapter(new PDLogicRuleMatcher(array(
                    'name'=>'name',
                    'description'=>'description'
                )))
            );
        }
    ),
    
    'deleteJobPosition'=>array(
        'class'=>'jobPosition.services.PDJobPositionDeleteService',
        'construct'=>function($jobPosition) {
            return new PDJobPositionDeleteService(
                $jobPosition
            );
        }
    ),

);
?>
