(function(app, $, Ladda, undefined){

    // register new tool funciton
    app.tools.loadingButton = function(obj) {
        var button = $(obj);

        if (!button.hasClass('btn') || button.attr('type') == 'text') {
            BtnApp.tools.warn('not suppoerted for loadingButton', button);
            return;
        }

        // wrap button in Ladda classes
        if (!button.hasClass('ladda-button')) {
            button.addClass('ladda-button');
            button.attr('data-style', 'expand-right');
            var span = $('<span>').addClass('ladda-label').html(button.html());
            button.empty().append(span);
        }

        var ladaObject = button.data('ladda-object');

        // if object not found then create and store in button
        if (!ladaObject) {
            ladaObject = Ladda.create(button.get(0));
            button.data('ladda-object', ladaObject);
        }

        return ladaObject;
    };

    // Add events
    var addEvents = function() {
        app.tools.findOnce('btn-loading').each(function() {
            var element = $(this);
            if (element.is('form')) {
                element.on('submit', function() {
                    var button = $(this).find('.btn-save, .btn-update, .btn-create');
                    if (button.length) {
                        l = app.tools.loadingButton(button);
                        if (l) {
                            l.start();
                        }
                    }

                });
            }
        });
    };

    app.init(function() {
        addEvents();
    });

    app.refresh(function() {
        addEvents();
    });

})(BtnApp, jQuery, Ladda);
