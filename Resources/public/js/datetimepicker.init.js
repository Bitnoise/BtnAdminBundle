(function(app, $, undefined){

    var addEvents = function() {
        app.tools.getOnce('btn-datetimepicker').each(function() {
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
