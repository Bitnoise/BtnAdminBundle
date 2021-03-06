/* global BtnApp, jQuery */
(function(app, $, undefined){
    'use strict';
    var addEvents = function(context) {
        // conditional rows mechanism
        app.tools.findOnce('btn-has-conditional-rows', context).each(function() {
            $(this).on('change', function () {
                var element = $(this);
                var condGroup = element.attr('btn-has-conditional-rows');
                // hide all from group
                var condRows = $('[btn-conditional-row-name='+condGroup+']');
                var referenceValue = element.val() || '';
                var condRowsFiltered = condRows
                    .filter('[btn-conditional-row-value]')
                    .filter(function(index, row) {
                        var conditionalRowValue = $(row).attr('btn-conditional-row-value');
                        if (conditionalRowValue === referenceValue) {
                            return true;
                        }
                        if (conditionalRowValue.indexOf('|' + referenceValue + '|') >= 0) {
                            return true;
                        }
                        return false;
                    })
                ;
                if (element.attr('type') === 'checkbox') {
                    if (element.attr('readonly') && !element.is(':checked')) {
                        // don't react on disabling readonly field
                    } else if (condRowsFiltered.length) {
                        condRowsFiltered.toggleClass('hidden', !element.is(':checked'));
                    } else {
                        condRows.addClass('hidden');
                    }
                } else {
                    condRows.addClass('hidden');
                    condRowsFiltered.removeClass('hidden');
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
