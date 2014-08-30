/* global BtnApp, Spinner, jQuery */
(function(app, Spinner, $, undefined){
    'use strict';
    var opts = {
        lines: 17, // The number of lines to draw
        length: 31, // The length of each line
        width: 9, // The line thickness
        radius: 60, // The radius of the inner circle
        corners: 1, // Corner roundness (0..1)
        rotate: 0, // The rotation offset
        direction: 1, // 1: clockwise, -1: counterclockwise
        color: '#000', // #rgb or #rrggbb or array of colors
        speed: 2.2, // Rounds per second
        trail: 100, // Afterglow percentage
        shadow: false, // Whether to render a shadow
        hwaccel: false, // Whether to use hardware acceleration
        className: 'spinner', // The CSS class to assign to the spinner
        zIndex: 2e9, // The z-index (defaults to 2000000000)
        top: '50%', // Top position relative to parent
        left: '50%' // Left position relative to parent
    };

    // set as default for plugin
    $.fn.spin.presets.flower = opts;

    // register new tool funciton
    app.tools.loadingContent = function(obj) {
        var element = $(obj);

        var spinner = element.data('spinner');

        if (!spinner) {
            spinner = new Spinner(opts);
            element.data('spinner', spinner);
        }

        return {
            start: function() {
                spinner.spin(element.get(0));

                return spinner;
            },
            stop: function() {
                spinner.stop();

                return spinner;
            }
        };

    };

})(BtnApp, Spinner, jQuery);
