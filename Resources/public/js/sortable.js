(function(app, $, undefined){

    var bindSortable = function() {
        if (typeof $.fn.sortable === 'undefined') {

            return;
        }
        var binded = $('[data-jq-ui]');

        if (binded.length && binded.attr('data-jq-ui') === 'sortable') {

            binded.sortable();
            binded.disableSelection();
            //update name attr on sort stop - set it to the current position
            binded.on("sortstop", function() {
                binded.children('div').find("[name^='btn_component_form_component']").each(function(index){
                    $(this).attr('name', $(this).attr('name').replace( /\[\d+\]/g, '[' + (index + 1) + ']'));
                });
            });
        };
    };

    app.init(function() {
        bindSortable();
    });

    app.refresh(function() {
        // addEvents();
    });

})(BtnApp, jQuery);
