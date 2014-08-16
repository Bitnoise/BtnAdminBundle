// main app object
var BtnAdminApp = {
    data: {
        debug: true
    },
    init: function() {
        BtnAdminApp.tools.log('init main admin app');
        PubSub.publish('btn_admin.is_ready');
    },
};

// handy tools
BtnAdminApp.tools = {
    log: function(msg) {
        BtnAdminApp.data.debug ? console.log(msg) : null;
    }
}
