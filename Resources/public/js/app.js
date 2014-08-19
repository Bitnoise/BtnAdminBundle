// main app object
var BtnApp = {
    data: {
        debug: true
    },
    triggerState: function (state, input) {
        var statePrefixed = 'btn_admin.' + state;
        switch (typeof input) {
            case 'function':
                PubSub.subscribe(statePrefixed, input);
                break;
            case 'object':
            case 'undefined':
                var parms = {context: this.tools.getContext(input)};
                this.tools.log(statePrefixed, parms);
                PubSub.publish(statePrefixed, parms);
                break;
        }
    },
    init: function(input) {
        this.triggerState('init', input);
    },
    ready: function(input) {
        this.triggerState('ready', input);
    },
    refresh: function(input) {
        this.triggerState('refresh', input);
    },
};

// handy tools
BtnApp.tools = {
    log: function(msg) {
        BtnApp.data.debug ? console.log(msg) : null;
    },
    getOnce: function(selector) {
        return jQuery('[data-' + selector + ']')
            .filter(':not([data-' + selector + '-binded])')
            .attr('data-' + selector + '-binded', true)
        ;
    }
}
