(function(PubSub, Ladda, $, undefined){

    var addFormLoadingEvent = function() {
        $('form[data-loading]')
            .filter(':not([data-loading-binded])')
            .data('loading-binded', true)
            .on('submit', function(e){
                var button = $(this).find('.ladda-button');
                if (button.length) {
                    var l = Ladda.create(button.get(0));
                    l.start();
                }
            });
    };

    PubSub.subscribe('btn_admin.is_ready', function() {
        addFormLoadingEvent();
    });

    PubSub.subscribe('btn_admin.refresh', function() {
        addFormLoadingEvent();
    });

})(PubSub, Ladda, jQuery);
