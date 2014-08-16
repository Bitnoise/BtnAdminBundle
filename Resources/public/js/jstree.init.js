$('[bind-jstree]')
    .jstree({
    "core" : {
        "animation" : 0
    }
});

$('[data-change-jstree]')// listen for event
    .on('changed.jstree', function (e, data) {
        if (typeof data.node !== 'undefined' && data.node.a_attr.href !== '#' && e.target.getAttribute('data-change-jstree') === 'reload') {
            window.location = data.node.a_attr.href;
        };
    })
;
