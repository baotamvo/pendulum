
define(['angularJs',
    'angularUi',
    'angularStrap',
    'angular/angular-sanitize',
    'app/modules/core',
    'app/modules/account',
    'app/modules/jobApplication',
    'app/modules/jobPosition',
    'app/modules/pilot'
],function(){

    angular.module('pendulum',
        ['ui','ngSanitize',
        'pendulum.core',
        '$strap.directives'
        ]);


})