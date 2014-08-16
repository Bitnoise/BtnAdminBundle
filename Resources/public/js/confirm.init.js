(function(PubSub, bootbox, $, undefined){

    var addConfirmEvent = function() {
        $('[data-btn-confirm]')
            .filter(':not([data-btn-confirm-binded])')
            .attr('data-btn-confirm-binded', true)
            .each(function(){
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

    PubSub.subscribe('btn_admin.is_ready', function() {
        addConfirmEvent();
    });

    PubSub.subscribe('btn_admin.refresh', function() {
        addConfirmEvent();
    });

})(PubSub, bootbox, jQuery);
