(function(PubSub, $, undefined){

    var addEvents = function() {
        $('[data-btn-colorpicker]')
            .filter(':not([data-btn-colorpicker-binded])')
            .attr('data-btn-colorpicker-binded', true)
            .each(function() {
                $(this).pickAColor({
                    allowBlank: $(this).attr('required') ? false : true,
                    inlineDropdown: true,
                });
            });
    };

    PubSub.subscribe('btn_admin.is_ready', function() {
        addEvents();
    });

    PubSub.subscribe('btn_admin.refresh', function() {
        addEvents();
    });

})(PubSub, jQuery);
