$('[data-confirm]').confirmation({
    title: $('[data-confirm]').data('confirm'),
    placement: 'bottom',
    onConfirm: function(e, element) {
        e.preventDefault();
        window.location = element.attr('href');
    }
});
