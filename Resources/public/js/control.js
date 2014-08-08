$('[data-confirm]').confirmation({
    title: $('[data-confirm]').data('confirm'),
    placement: 'bottom',
    onConfirm: function(e, element) {
        e.preventDefault();
        if (typeof element.attr('href') != 'undefined') {
            window.location = element.attr('href');
        }
        element.parents('form').unbind('submit').submit();
    }
});
