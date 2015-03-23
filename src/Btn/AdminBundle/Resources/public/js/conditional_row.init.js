/* global BtnApp, bootbox, jQuery */
(function(app, $, undefined){
    'use strict';
    var addEvents = function(context) {
        // conditional rows mechanizm
        app.tools.findOnce('btn-has-conditional-rows', context).each(function() {
            $(this).on('change', function () {
                var element = $(this);
                var condGroup = element.attr('btn-has-conditional-rows');
                // hide all from group
                var condRows = $('[btn-conditional-row-name='+condGroup+']');
                if (element.attr('type') == 'checkbox') {
                    if (element.attr('readonly') && !element.is(':checked')) {
                        // don't react on disableing readonly field
                    } else {
                        condRows.filter('[btn-conditional-row-value='+element.val()+']').toggleClass('hidden', !element.is(':checked'));
                    }
                } else {
                    condRows.addClass('hidden');
                    condRows.filter('[btn-conditional-row-value='+element.val()+']').removeClass('hidden');
                }
            }).trigger('change');
        });
    };

    app.init(function(msg, data) {
        addEvents(data.context);
    });

    app.refresh(function(msg, data) {
        addEvents(data.context);
    });

})(BtnApp, jQuery);
