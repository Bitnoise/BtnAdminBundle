// subscribe event callback test
PubSub.subscribe('btn_admin.is_ready', function(e, data) {
    BtnAdminApp.tools.log(data.message);
})

// main app object
var BtnAdminApp = {
    data: {
        debug: true
    },
    init: function() {
        BtnAdminApp.tools.log('init main admin app');
        PubSub.publish('btn_admin.is_ready', {message: 'hello world'})
    },
};

// handy tools
BtnAdminApp.tools = {
    log: function(msg) {
        BtnAdminApp.data.debug ? console.log(msg) : null;
    }
}

// launch app
BtnAdminApp.init();
