/* global BtnApp, jQuery */
(function(app, $, undefined){
    'use strict';
    var addEvents = function() {
        app.tools.findOnce('btn-datetimepicker').each(function() {
            var element = $(this);
            element.datetimepicker();
        });
    };

    app.init(function() {
        addEvents();
    });

    app.refresh(function() {
        addEvents();
    });

})(BtnApp, jQuery);
