(function(app, $, undefined){

    var addEvents = function() {
        app.tools.getOnce('btn-colorpicker').each(function() {
            var element = $(this);
            element.pickAColor({
                allowBlank: element.attr('required') ? false : true,
                inlineDropdown: true,
            });
        });
    };

    app.init(function() {
        addEvents();
    });

    app.refresh(function() {
        addEvents();
    });

})(BtnApp, jQuery);
