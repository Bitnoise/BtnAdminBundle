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
                    placeholder: '<tr class="placeholder"/>',
                      onDrop: function (item, container, _super) {
                        var url = element.attr('btn-sortable');
                        if (url) {
                            var data = element.sortable('serialize').get();
                            var jsonString = JSON.stringify(data, null, ' ');
                            jQuery.post(url, jsonString);
                        }
                        _super(item, container);
                      }
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
