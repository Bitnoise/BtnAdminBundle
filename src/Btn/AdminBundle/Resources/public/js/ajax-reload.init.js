/* global BtnApp, jQuery */
(function(app, $, undefined){
    'use strict';
    var addEvents = function(context) {
        app.tools.findOnce('btn-ajax-reload', context).each(function() {
            var element = $(this);
            element.on('change', function(){
                var form = element.parents('form').first();
                var spinner = app.tools.loadingContent(form);
                spinner.start();
                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                }).done(function(data){
                    var newForm = $(data);
                    if (newForm.is('form')) {
                        form.replaceWith(newForm);
                        app.refresh(newForm);
                    }
                }).always(function(){
                    spinner.stop();
                });
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
