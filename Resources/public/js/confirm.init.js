(function(app, bootbox, $, undefined){

    var addEvent = function() {
        app.getOnce('btn-confirm').each(function(){
            var element = $(this);
            if (element.is('a')) {
                element.on('click', function(e){
                    e.preventDefault();
                    bootbox.confirm(element.attr('data-btn-confirm'), function(result){
                        if (result) {
                            window.location.href = element.attr('href');
                        }
                    });
                });
            }
        });
    };

    app.ready(function() {
        addEvent();
    });

    PubSub.refresh(function() {
        addEvent();
    });

})(BtnApp, bootbox, jQuery);
