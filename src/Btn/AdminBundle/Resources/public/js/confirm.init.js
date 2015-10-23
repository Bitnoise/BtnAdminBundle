/* global BtnApp, bootbox, jQuery, Translator */
(function(app, bootbox, $, Translator, undefined){
    'use strict';
    var addEvents = function(context) {

        app.tools.findOnce('btn-remove', context).each(function(){
            var element = $(this);
            if ($.fn.btsConfirmButton) {
                var options = {className: null};
                if (element.attr('btn-remove-msg')) {
                    options.msg = element.attr('btn-remove-msg');
                } else if (Translator) {
                    options.msg = Translator.trans('btn_admin.btn_remove.msg');
                }
                element.off('click').btsConfirmButton(options, function() {
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

})(BtnApp, bootbox, jQuery, (typeof Translator != 'undefined') ? Translator : null);
