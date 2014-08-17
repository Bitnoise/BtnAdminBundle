(function(app, $, undefined){

    var addEvents = function() {
        app.getOnce('btn-colorpicker').each(function() {
            var element = $(this);
            element.pickAColor({
                allowBlank: element.attr('required') ? false : true,
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
