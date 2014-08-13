$('#tree')
    .on('changed.jstree', function (e, data) {
        if (typeof data.node !== 'undefined' && data.node.a_attr.href !== '#') {
            window.location = data.node.a_attr.href;
        };
    })
    .jstree({
    "core" : {
        "animation" : 0
    }
});
