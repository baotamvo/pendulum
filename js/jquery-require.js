define(['jQueryUi'],function(){
    $(function(){
        $('.datepicker').datepicker();
        $('ul.nav > li > a[href="' + document.location.href + '"]').parent().addClass('active');
        $('ul.nav > li > a[href="' + document.location.pathname + '"]').parent().addClass('active');
        $('form .row').removeClass('row').addClass('control-group');
        $('form .errorMessage').removeClass('errorMessage').addClass('help-inline');
        $('form input[type="submit"]').addClass('btn btn-primary');
    })
    return jQuery;
})