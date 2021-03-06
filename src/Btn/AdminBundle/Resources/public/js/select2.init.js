/* global BtnApp, jQuery */
(function(app, $, undefined){
    'use strict';
    var addEvents = function(context) {
        app.tools.findOnce('btn-select2', context).each(function() {
            var element = $(this);
            var options = element.attr('btn-select2-options');
            if ('string' === typeof options) {
                options = $.parseJSON(options);
            }
            options = options || {};

            if (element.is('[btn-select2-minimum-results-for-search]') && !('minimumResultsForSearch' in options)) {
                options.minimumResultsForSearch = parseInt(element.attr('btn-select2-minimum-results-for-search'), 10);
            }

            if (element.is('[btn-select2-tree]') && !('formatResult' in options)) {
                options.formatResult = function(state) {
                    if (!state.id) {
                        return state.text; // optgroup
                    }
                    var text = state.text;

                    text = text.replace('|_', '&nbsp;');
                    text = text.replace(/^[\_]+/, function(found) {
                        return new Array(found.length * 4).join('&nbsp;');
                    });

                    return text;
                };
            } else if (!('formatResult' in options)) {
                options.formatResult = function(state) {
                    return '<span btn-select2-value="'+state.id+'">'+state.text+'</span>';
                };
            }

            if (!('formatSelection' in options)) {
                options.formatSelection = function(state) {
                    var parent = $(state.element).parent();
                    var text = state.text.replace(/^[\_|]+/, '');
                    if ('OPTGROUP' === parent.prop('tagName') && parent.attr('label')) {
                        return  text + ' <small class="optgroup">('+parent.attr('label')+')</small>';
                    }

                    return text;
                };
            }

            element.select2(options);

            if (element.attr('readonly')) {
                element.select2('readonly', true);
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
