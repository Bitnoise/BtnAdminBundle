(function(app, $, Ladda, undefined){

    var addEvent = function() {
        app.tools.getOnce('btn-loading').each(function() {
            var element = $(this);
            if (element.is('form')) {
                element.on('submit', function() {
                    var button = $(this).find('.ladda-button');
                    if (button.length) {
                        var l = Ladda.create(button.get(0));
                        l.start();
                    }
                });
            }
        });
    };

    app.init(function() {
        addEvent();
    });

    app.refresh(function() {
        addEvent();
    });

})(BtnApp, jQuery, Ladda);
