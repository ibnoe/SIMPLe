jQuery(function () {
    $('.chart').visualize({
        type:'bar'
    });

    $('.close').live('click', function () {
        $(this).parent().fadeOut('fast');
    })

})