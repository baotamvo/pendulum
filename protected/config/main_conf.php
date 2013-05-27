<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return CMap::mergeArray(array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name'=>'My Pendulum Application',
        'theme'=>'classic',
        // preloading 'log' component
        'preload'=>array('log'),
        'onBeginRequest'=>function() {
            Yii::beginProfile('application');
        },
        'onEndRequest'=>function() {
            Yii::endProfile('application');
        },

        // aliases used in Yii::import()
        'aliases'=>array(
            'comp' => 'application.components',
            '_app' => 'application',
            'PDObjectFactory'=> 'app.core.PDObjectFactory'
        ),

        'modules'=>array(
            'app',
            'account',
            'service',
            'airline',
            'jobPosition',
            'jobPosting',
            'pilot',
            'bootstrap',
            'page',
            'airlineAccount',
            'jobApplicationSearch'
        ),

        // autoloading model and component classes
        'import'=>array(
            'application.models.*',

            'app.base.*',
            'app.core.*',
            'app.core.dependencyInjection.*',
            'service.base.PDBaseService'
        ),

        // application components
        'components'=>array(
            'clientScript'=>array(
                'class'=>'PDClientScript'
            ),
            'user'=>array(
                'class'=>'PDWebUser',
                // enable cookie-based authentication
                'allowAutoLogin'=>true,
                'autoUpdateFlash' => false,
                'loginUrl'=>array('/airlineAccount/auth/login')
            ),
            'string'=>array(
                'class'=>'app.core.components.PDStringFormatter'
            ),
            'themeManager'=>array(
                'themeClass'=>'app.core.models.PDTheme'
            ),
            'session'=>array(
                'sessionName'=>'ws-airline-sess'
            ),
            'request'=>array(
                'class'=>'PDHttpRequest',
                'csrfTokenName'=>'csrf-token',
                'enableCookieValidation'=>true,
                'enableCsrfValidation'=>true,
            ),
            'authManager'=>array(
                'class'=>'CDbAuthManager'
            ),
            // uncomment the following to enable URLs in path-format
            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName'=>false,
                'rules'=>array(
                    '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                ),
            ),

            'passwordHasher'=>array(
                'class'=>'app.core.PDPasswordHasher'
            ),

            'db'=>array(
                'emulatePrepare' => true,
                'charset' => 'utf8',
                'pdoClass' => 'PDPDO',
            ),

            'errorHandler'=>array(
                'class'=>'app.core.PDErrorHandler',
                'errorAction'=>'site/error',
            ),

            'html'=>array(
                'class'=>'app.core.PDHtml'
            ),

            'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
                    array(
                        'class'=>'CFileLogRoute',
                        'levels'=>'error, warning',
                        'logFile'=>'error.log'
                    ),
                    array(
                        'class'=>'CFileLogRoute',
                        'levels'=>'service-error',
                        'logFile'=>'service-error.log'
                    ),
                ),
            ),
            'bootstrap'=>array(
                'class'=>'bootstrap.components.Bootstrap',
            ),
            'objectFactory'=>array(
                'class'=>'PDObjectFactory'
            ),

            'PDWidgetFactory'=>array(
                'class'=>'PDWidgetFactory'
            ),
            'widgetFactory'=>array(
                'class'=>'PDCoreWidgetFactory',
                'widgets'=>array(
                    'CActiveForm'=>array(
                        'htmlOptions'=>array(
                            'class'=>'form-vertical'
                        )
                    )
                )
            ),

            'urlFactory'=>array(
                'class'=>'PDUrlFactory'
            ),

            'validatorFactory'=>array(
                'class'=>'PDValidatorFactory'
            ),


            'configLocator'=>array(
                'class'=>'PDConfigLocator',
            ),

            'mapper'=>array(
                'class'=>'PDObjectMapper'
            ),

            'urls'=>array(
                'class'=>'PDObjectLocator',
                'objectFactoryId'=>'urlFactory',
                'objects'=>(dirname(__FILE__).'/maps/url_map.php')
            ),

            'models'=>array(
                'class'=>'PDObjectLocator',
                'objects'=>(dirname(__FILE__).'/maps/model_map.php')
            ),
            'widgets'=>array(
                'class'=>'PDObjectLocator',
                'objectFactoryId'=>'PDWidgetFactory',
                'objects'=>dirname(__FILE__).'/maps/widget_map.php'
            ),
            'validators'=>array(
                'class'=>'PDObjectLocator',
                'objects'=>dirname(__FILE__).'/maps/validator_map.php'
            ),
            'aspects'=>array(
                'class'=>'PDObjectLocator',
                'objects'=>dirname(__FILE__).'/maps/aspect_map.php'
            ),
        ),

        // application-level parameters that can be accessed
        // using Yii::app()->params['paramName']
        'params'=>array(
            // this is used in contact page
            'adminEmail'=>'webmaster@example.com',
        ),
    )
    ,require_once(dirname(__FILE__).'/local_conf.php'));