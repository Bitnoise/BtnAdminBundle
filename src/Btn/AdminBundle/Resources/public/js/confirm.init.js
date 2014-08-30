/* global BtnApp, bootbox, jQuery */
(function(app, bootbox, $, undefined){
    'use strict';
    var addEvents = function(context) {

        app.tools.findOnce('btn-remove', context).each(function(){
            var element = $(this);
            if ($.fn.btsConfirmButton) {
                element.off('click').btsConfirmButton({className: null}, function() {
                    if (element.is('a')) {
                        window.location.href = element.attr('href');
                    } else {
                        element.triggerHandler('btnRemove');
                    }
                });
            }
        });

        app.tools.findOnce('btn-confirm', context).each(function(){
            var element = $(this);
            if (element.is('a')) {
                element.on('click', function(e){
                    e.preventDefault();
                    bootbox.confirm(element.attr('btn-confirm'), function(result){
                        if (result) {
                            if (app.tools.loadingButton) {
                                app.tools.loadingButton(element).start();
                            }
                            window.location.href = element.attr('href');
                        }
                    });
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

})(BtnApp, bootbox, jQuery);
