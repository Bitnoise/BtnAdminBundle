// main app object
var BtnApp = {
    data: {
        debug: true
    },
    init: function() {
        BtnApp.tools.log('init main admin app');
        PubSub.publish('btn_admin.ready');
    },
    ready: function(callback) {
        switch (typeof callback) {
          case 'function':
            PubSub.subscribe('btn_admin.ready', callback);
            break;
          case 'undefined':
            PubSub.publish('btn_admin.ready');
            break;
        }
    },
    refresh: function(callback) {
        switch (typeof callback) {
          case 'function':
            PubSub.subscribe('btn_admin.refresh', callback);
            break;
          case 'undefined':
            PubSub.publish('btn_admin.refresh');
            break;
        }
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
