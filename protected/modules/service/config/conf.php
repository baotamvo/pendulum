<?php

/**
 * Description
 * declaration of active services
 */

return array(
    'import'=>array(
        'service.base.*'
    ),
    'components'=>array(

        'port'=>array(
            'class'=>'service.core.PDServicePort'
        ),

        'services'=>array(
            'class'=>'PDObjectLocator',
            'objects'=>dirname(__FILE__) . '/maps/service_map.php',
        ),

        'responseMapper'=>array(
            'class'=>'service.components.PDResponseMapper'
        ),

        'models'=>array(
            'class'=>'PDObjectLocator',
            'objects'=>array(
                'transaction'=>array(
                    'class'=>'service.models.PDServiceTransaction',
                    'construct'=>function($service) {
                        return new PDServiceTransaction($service);
                    }
                ),
                'jsonResponse'=>array(
                    'class'=>'service.models.response.PDJSONServiceResponse'
                ),
            )
        ),

//        'servicePortManager'=>array(
//            'ports'=>array(
//                'auth'=>array(
//                    'serviceId'=>'auth',
//                    'responseId'=>'objective_json',
//                    'requestInterceptors'=>array(
//                        'logger','accessControl',
//                    ),
//                    'reponseInterceptors'=>array(
//                        'logger',
//                    )
//                )
//            )
//        )
    )
)
?>
