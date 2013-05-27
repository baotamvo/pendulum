<?php


return array(
    'loginPage'=>array(
        'construct'=>function(){
            return app()->models->get('url',array(
                'url'=>array('airlineAccount/auth/login'),
                'label'=>'Login',
            ));
        }
    ),

    'signupPage'=>array(
        'construct'=>function(){
            return app()->models->get('url',array(
                'url'=>array('site/registration'),
                'label'=>'Signup',
            ));
        }
    ),

    'contactPage'=>array(
        'construct'=>function(){
            return app()->models->get('url',array(
                'url'=>array('site/contact'),
                'label'=>'Contact',
            ));
        }
    ),

    'homePage'=>array(
        'construct'=>function(){
            return app()->models->get('url',array(
                'url'=>array('airlineAccount/dashboard/index'),
                'label'=>'Home',
            ));
        }
    ),

    'profilePage'=>array(
        'construct'=>function(){
            return app()->models->get('url',array(
                'url'=>array('airlineAccount/dashboard/profile'),
                'label'=>'Profile',
            ));
        }
    ),

    'aboutPage'=>array(
        'construct'=>function(){
            return app()->models->get('url',array(
                'url'=>array('site/page',array('view'=>'about')),
                'label'=>'About',
            ));
        }
    ), 

    'logout'=>array(
        'construct'=>function(){
            return app()->models->get('url',array(
                'url'=>array('airlineAccount/auth/logout'),
                'label'=>'Logout',
            ));
        }
    ),
    
    'urlListingPage'=>array(
        'construct'=>function(){
            return app()->models->get('url',array(
                'url'=>array('site/links'),
                'label'=>'Links',
            ));
        }
    ),
    'serviceListingPage'=>array(
        'construct'=>function(){
            return app()->models->get('url',array(
                'url'=>array('site/services'),
                'label'=>'Links',
            ));
        }
    ),

    'editAccountInfoPage'=>array(
        'construct'=>function(){
            return app()->models->get('url',array(
                'url'=>'',
                'label'=>'Edit Account Info',
            ));
        }
    ),
)

?>
