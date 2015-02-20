/* global BtnApp, jQuery */
(function(app, $, undefined){
    'use strict';
    var addEvents = function() {
        app.tools.findOnce('btn-datetimepicker').each(function() {
            var element = $(this);
            element.datetimepicker();
            if (element.hasClass('btn-time')) {
                element.data('datetimepicker').picker.addClass('btn-time');
            }
        });
    };

    app.init(function() {
        addEvents();
    });

    app.refresh(function() {
        addEvents();
    });

})(BtnApp, jQuery);
