(function(app, $, undefined){

    var addEvents = function() {
        app.getOnce('btn-datetimepicker').each(function() {
            var element = $(this);
            element.datetimepicker();
        });
    };

    app.ready(function() {
        addEvents();
    });

    app.refresh(function() {
        addEvents();
    });

})(BtnApp, jQuery);
