/* global BtnApp, jQuery, JSON */
(function(app, $, JSON, undefined){
    'use strict';
    var addEvents = function(context) {
        app.tools.findOnce('btn-colorpicker', context).each(function() {
            var element = $(this);

            var options = {
                allowBlank: element.attr('required') ? false : true,
                showSpectrum: element.attr('btn-colorpicker-spectrum') || true,
                showAdvanced: element.attr('btn-colorpicker-advanced') || true,
                showBasicColors: element.attr('btn-colorpicker-basic') || true,
                allowHexFocus: false,
                allowButtonTab: false,
                inlineDropdown: true,
            };

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
