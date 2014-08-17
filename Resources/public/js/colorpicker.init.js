(function(app, $, undefined){

    var addEvents = function() {
        app.getOnce('btn-colorpicker').each(function() {
            $(this).pickAColor({
                allowBlank: $(this).attr('required') ? false : true,
                inlineDropdown: true,
            });
        });
    };

    app.ready(function() {
        addEvents();
    });

    app.refresh(function() {
        addEvents();
    });

})(BtnApp, jQuery);
