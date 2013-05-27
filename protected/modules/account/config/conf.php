<?php
return array(
    'components'=>array(
        'models'=>array(
            'class'=>'PDObjectLocator',
            'objects'=>array(
                'user'=>array(
                    'class'=>'account.models.PDUser',
                ),
                'userType'=>array(
                    'class'=>'account.models.type.PDUserType'
                )
            )
        ),

        'aspects'=>array(
            'class'=>'PDObjectLocator',
            'objects'=>array(
                'accountTypeManager'=>array(
                    'class'=>'account.behaviors.PDAccountTypeManager'
                ),
                'userProfileBehavior'=>array(
                    'class'=>'account.behaviors.PDUserProfileBehavior'
                )
            )
        )
    )
);