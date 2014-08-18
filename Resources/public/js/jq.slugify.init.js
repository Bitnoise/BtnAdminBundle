(function(app, $, undefined){

    var addEvents = function() {
        app.tools.getOnce('btn-slug').each(function() {
            var element = $(this);
            var source  = $(element.attr('data-slug-source-selector'));
            if (source) {
                element.slugify(source);
            }
        });
    };

    app.init(function() {
        addEvents();
    });

    app.refresh(function() {
        addEvents();
    });

})(BtnApp, jQuery);
