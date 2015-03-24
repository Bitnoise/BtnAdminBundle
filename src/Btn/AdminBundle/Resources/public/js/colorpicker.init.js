/* global BtnApp, jQuery, JSON */
(function(app, $, JSON, undefined){
    'use strict';
    var addEvents = function(context) {
        app.tools.findOnce('btn-colorpicker', context).each(function() {
            var element = $(this);

            var options = {
                allowBlank: element.attr('required') ? false : true,
                allowHexFocus: false,
                allowButtonTab: false,
                inlineDropdown: true,
            };

            var booleanMap = {
                showSpectrum: 'btn-colorpicker-spectrum',
                showAdvanced: 'btn-colorpicker-advanced',
                showBasicColors: 'btn-colorpicker-basic',
            };

            $.each(booleanMap, function(option, attr) {
                var value = element.attr(attr);
                if (typeof value === 'string' && value === 'false') {
                    value = false;
                } else {
                    value = true;
                }
                options[option] = value;
            });

            if (options.showBasicColors) {
                var basicColors = element.attr('btn-colorpicker-basic-colors');
                if (basicColors) {
                    options.basicColors = JSON.parse(basicColors);
                }
            }

            element.pickAColor(options);
        });
    };

    app.init(function(msg, data) {
        addEvents(data.context);
    });

    app.refresh(function(msg, data) {
        addEvents(data.context);
    });

})(BtnApp, jQuery, JSON);
