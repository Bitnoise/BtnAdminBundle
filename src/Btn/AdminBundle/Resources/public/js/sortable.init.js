/* global BtnApp, jQuery */
(function(app, $, undefined){
    'use strict';
    var addEvents = function(context) {
        app.tools.findOnce('btn-sortable', context).each(function() {
            var element = $(this);
            if (element.is('table')) {
                var options = {
                    containerSelector: 'table',
                    itemPath: '> tbody',
                    itemSelector: 'tr',
                    placeholder: '<tr class="placeholder"/>',
                    onDrop: function (item, container, _super) {
                        var url = element.attr('btn-sortable');
                        if (url) {
                            var spinner = app.tools.loadingContent(element);
                            spinner.start();
                            var data = {items: element.sortable('serialize').get()[0]};
                            data.offset = parseInt(element.attr('data-offset') || 0, 10);
                            var jsonString = JSON.stringify(data, null, ' ');
                            jQuery.post(url, jsonString).always(function() {
                                spinner.stop();
                            });
                        }
                        _super(item, container);
                    }
                };
                if ($('table').find('td.move-position').length > 0) {
                    options.handle = 'td.move-position';
                }
                element.addClass('sorted_table').sortable(options);
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
