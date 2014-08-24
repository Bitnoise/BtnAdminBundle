/* global BtnApp, jQuery */
(function(app, $, undefined){

    var addEvents = function(context) {
        app.tools.findOnce('btn-colorpicker', context).each(function() {
            var element = $(this);
            element.pickAColor({
                allowBlank: element.attr('required') ? false : true,
                inlineDropdown: true,
            });
        });
    };

    app.init(function(msg, data) {
        addEvents(data.context);
    });

    app.refresh(function(msg, data) {
        addEvents(data.context);
    });

})(BtnApp, jQuery);
