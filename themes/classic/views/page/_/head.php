<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />


    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <?php
    //CSRF TOKEN as meta tag
    $request = app()->request;
    if($request->enableCsrfValidation)
        echo app()->html->metaTag(
            $request->getCsrfToken(),
            $request->csrfTokenName
        )
    ?>

    <?php app()->bootstrap->register(); ?>

    <title><?php echo $this->title ?></title>

    <!--[if lte IE 8]>
    <script>
        // The ieshiv takes care of our ui.directives, bootstrap module directives and
        // AngularJS's ng-view, ng-include, ng-pluralize and ng-switch directives.
        // However, IF you have custom directives (yours or someone else's) then
        // enumerate the list of tags in window.myCustomTags
        window.myCustomTags = [ 'ws-focus','ws-modal-show','ws-datepicker','ws-block' ];
    </script>
    <script src="<?php echo $this->getJs('angular-ui/build/angular-ui-ieshiv.min.js') ?>"></script>
    <![endif]-->

    <script data-main="<?php echo $this->getJs('app-bootstrap') ?>"
            src="<?php echo $this->getJs('require.min.js') ?>"></script>

    <!--jquery ui-->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->getCss('bootstrap/jquery-ui/bootstrap-jquery-ui.css') ?>"

    <!--Angular UI-->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->getJs('angular-ui/build/angular-ui.min.css'); ?>" />

    <!-- awesome font -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->getCss('bootstrap/font-awesome/css/font-awesome.min.css') ?>" />
    <!--[if lte IE 7]>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->getCss('bootstrap/font-awesome/css/font-awesome-ie7.min.css') ?>" />
    <![endif]-->


    <!-- full calendar -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->getJs('fullcalendar/fullcalendar.css'); ?>" />

    <!-- enhanced bootstrap modal-->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->getCss('bootstrap/bootstrap-modal/bootstrap-modal.css'); ?>" />


    <!--pine notify-->
    <link href="<?php echo $this->getJs('jQuery/pnotify/jquery.pnotify.default.css') ?>" media="all" rel="stylesheet" type="text/css" />


    <!-- custom styling -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->getCss('form.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->getThemeCss('style.css') ?>" />
</head>

