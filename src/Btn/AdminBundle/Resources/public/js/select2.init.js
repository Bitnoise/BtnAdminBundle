/* global BtnApp, jQuery */
(function(app, $, undefined){
    'use strict';
    var addEvents = function(context) {
        app.tools.findOnce('btn-select2', context).each(function() {
            var element = $(this);
            var options = element.attr('btn-select2-options');
            if ('string' === typeof options) {
                options = $.parseJSON(options);
            }
            element.select2(options || {});
        });
    };

    app.init(function(msg, data) {
        addEvents(data.context);
    });

    app.refresh(function(msg, data) {
        addEvents(data.context);
    });

})(BtnApp, jQuery);
