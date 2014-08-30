/* global BtnApp, jQuery */
(function(app, $, undefined){
    'use strict';
    var addEvents = function(context) {
        app.tools.findOnce('btn-jstree', context).each(function() {
            var element = $(this);
            element.jstree({
                'core' : {
                    'animation' : 0
                }
            });
            if (element.attr('btn-jstree-change')) {
                element.on('changed.jstree', function (e, data) {
                    if (typeof data.node !== 'undefined' && data.node.a_attr.href !== '#' && e.target.getAttribute('btn-jstree-change') === 'reload') {
                        window.location = data.node.a_attr.href;
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
