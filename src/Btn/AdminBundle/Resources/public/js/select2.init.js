/* global BtnApp, jQuery */
(function(app, $, undefined) {
    'use strict';
    var addEvents = function(context){
        app.tools.findOnce('btn-select2', context).each(function() {
            var element = $(this);
            var options = element.attr('btn-select2-options');
            var isAjax = element.attr('btn-select2-is-ajax');
            if ('string' === typeof options) {
                options = $.parseJSON(options);
            }
            options = options || {};

            if (!isAjax) {
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
                            return text + ' <small class="optgroup">('+parent.attr('label')+')</small>';
                        }

                        return text;
                    };
                }
            } else {
                var routePath = element.attr('btn-select2-route-path');
                options. minimumInputLength = 3;

                var prefix = Date.now(),
                    cache = {};
                options.ajax = {
                    url: routePath,
                    dataType: 'json',
                    delay: 750,
                    transport: function(params) {
                        var success = params.success,
                            failure = params.error;
                        if (element.attr('btn-select2-ajax-cache')) {
                            var key = prefix + ' page:' + 1 + ' ' + params.data.q,
                                cacheTimeout = 60000;
                            if (typeof cache[key] === 'undefined' || (cacheTimeout && Date.now() >= cache[key].time)) {
                                $.ajax(params).fail(failure).done(function(data) {
                                    cache[key] = {
                                        data: data,
                                        time: cacheTimeout ? Date.now() + cacheTimeout : null
                                    };
                                    success(data);
                                });
                            } else {
                                success(cache[key].data);
                            }
                        } else {
                            $.ajax(params).fail(failure).done(success);
                        }
                    },
                    data: function(params) {
                        return {
                            q: params
                        };
                    },
                    results: function(data) {
                        var results, more = false, response = {};

                        if ($.isArray(data)) {
                            results = data;
                        } else if (typeof data === 'object') {
                            // assume remote result was proper object
                            results = data.results;
                            more = data.more;
                        } else {
                            // failsafe
                            results = [];
                        }
                        response.results = results;

                        return response;
                    }
                };
                options.initSelection = function(element, callback) {
                    var id = element.attr('btn-select2-ajax-id'),
                        text = element.attr('btn-select2-ajax-text');
                    if(typeof id !== 'undefined'){
                        element.val(id);
                        callback({ id: id, text: text });
                    }else{
                        callback();
                    }
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
