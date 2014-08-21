(function(app, $, undefined){

    var addEvents = function() {
        app.tools.findOnce('btn-datetimepicker').each(function() {
            var element = $(this);
            element.datetimepicker();
        });
    };

    app.init(function() {
        addEvents();
    });

    app.refresh(function() {
        addEvents();
    });

})(BtnApp, jQuery);
