require.config({
    paths: {
        spin: 'spin.min',
        blockUI: 'jquery/blockUI',
        angularJs: 'angular/angular.min',
        angularUi: 'angular-ui/build/angular-ui.min',
        angularStrap: 'angular/angular-strap.min',
        pNotify: 'jQuery/pnotify/jquery.pnotify',
        tinyMCE: 'jQuery/tiny_mce/tiny_mce',
        jTinyMCE: 'jQuery/tiny_mce/jquery.tinymce',
        jquery: 'jquery-require',
        jQueryMain: 'jquery.min',
        jQueryUi: 'jquery-ui/jquery-ui-1.10.2.custom.min',
        fullCalendar: 'fullcalendar/fullcalendar.min',
        maskedInput: 'jQuery/jquery.maskedinput'
    },
    shim: {
        tinyMCE: {
            deps:['jQueryMain']
        },
        jTinyMCE: {
            deps:['tinyMCE','jQueryMain']
        },
        angularJs: {
            deps:['jQueryMain']
        },
        'angular/angular-sanitize' : {
            deps:['angularJs']
        },
        angularUi: {
            deps:['angularJs','jTinyMCE','jQueryUi','maskedInput']
        },
        angularStrap: {
            deps:['angularJs','angularUi']
        },
        blockUI:{
            deps:['jQueryMain']
        },
        jQueryUi:{
            deps:['jQueryMain']
        },
        fullCalendar:{
            deps:['jQueryMain']
        },
        'jQuery/jquery.browser':{
            deps:['jQueryMain']
        },
        maskedInput:{
            deps:['jQueryMain','jQuery/jquery.browser']
        },
        'bootstrap/bootstrap-modal':{
            deps:['bootstrap/bootstrap-modalmanager','jQueryMain']
        },
        'bootstrap/bootstrap-modalmanager':{
            deps:['jQueryMain']
        }


    }
});

require([
    'angularJs','app/main'],
function(){
    angular.bootstrap(document,['pendulum']);
})