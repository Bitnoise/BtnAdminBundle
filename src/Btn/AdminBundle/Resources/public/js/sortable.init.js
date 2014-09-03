/* global BtnApp, jQuery */
(function(app, $, undefined){
    'use strict';
    var addEvents = function(context) {
        app.tools.findOnce('btn-sortable', context).each(function() {
            var element = $(this);
            if (element.is('table')) {
                element.addClass('sorted_table').sortable({
                    containerSelector: 'table',
                    itemPath: '> tbody',
                    itemSelector: 'tr',
                    placeholder: '<tr class="placeholder"/>'
                });
            }
        });
    };

    app.init(function(msg, data) {
        addEvents(data.context);
    });

    app.refresh(function(msg, data) {
        addEvents(data.context);
    });

})(BtnApp, jQuery);
