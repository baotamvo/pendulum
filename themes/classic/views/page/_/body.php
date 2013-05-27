<?php
$theme = app()->theme;
?>
<body>

    <script>
//    $(document).ready(function(){
//        $('ul.nav > li > a[href="' + document.location.href + '"]').parent().addClass('active');
//        $('ul.nav > li > a[href="' + document.location.pathname + '"]').parent().addClass('active');
//        $('form .row').removeClass('row').addClass('control-group');
//        $('form .errorMessage').removeClass('errorMessage').addClass('help-inline');
//        $('form input[type="submit"]').addClass('btn btn-primary');
//    })
    </script>

    <div id="page-modal-wrapper">
        <?php
        app()->load('page/widgets/modal')->run();
        ?>
    </div>

    <div id="header">
        <?php app()->load('page/widgets/header')->run() ?>
    </div>

    <div class="container clear-top" id="page">
        <div class="row-fluid bodycontainer">
            <div class="body">
                <div class="row-fluid">
                    <div class="span12" id="notification">
                        <?php
                        app()->load('page/widgets/notification')->run();
                        ?>
                    </div>
                </div>

                <div class="row-fluid">
                    <?php
                    if($content = $this->getChild('content'))
                        $content->run();
                    else
                        echo $this->content;
                    ?>
                </div>
            </div>
        </div>


        <!-- footer -->

        <div class="row-fluid" >
            <div class="footercontainer">
                <div class="footer">
                    <?php
                    app()->load('page/widgets/footer')->run();
                    ?>
                </div>
            </div>
        </div>



        <div class="clearfix"></div>

    </div><!-- page -->
</body>