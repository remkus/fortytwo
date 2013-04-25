jQuery(function ($) {

    $('.widget-ft-tabs .nav > .dropdown > a').html($('.widget-ft-tabs .nav .dropdown-menu > li.active').text() + ' <b class="caret"></b>');

    $('.widget-ft-tabs .nav .dropdown-menu > li > a').on('click', function(){
        $('.widget-ft-tabs .nav > .dropdown > a').html($(this).text() + ' <b class="caret"></b>');
    });
})
