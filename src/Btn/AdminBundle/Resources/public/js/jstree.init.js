/* global BtnApp, jQuery */
(function(app, $, undefined){
    'use strict';
    //diable drag and drop at start
    var allowDnD = true;
    //init and bind jstree events
    var addEvents = function(context) {
        app.tools.findOnce('btn-jstree', context).each(function() {
            var element = $(this),
                spinner = app.tools.loadingContent(element);

            element.jstree({
                'core': {
                    'animation' : 0,
                    'check_callback' : function (operation, node, node_parent, node_position, more) {
                        // operation can be 'create_node', 'rename_node', 'delete_node', 'move_node' or 'copy_node'
                        //if operation is move_node and node is draggable
                        return (operation === 'move_node' && node.data.jstree.draggable && allowDnD) ? true : false;
                    }
                },
                'plugins' : ['dnd'],

            });
            if (element.attr('btn-jstree-change')) {
                element.on('changed.jstree', function (e, data) {
                    if (typeof data.node !== 'undefined' && data.node.a_attr.href !== '#' && e.target.getAttribute('btn-jstree-change') === 'reload') {
                        window.location = data.node.a_attr.href;
                    }
                });
            }
            //bind behavior on drag stop event
            element.on('move_node.jstree', function (e, data) {
                //prepare params for back-end
                var params = {
                    data: {
                        newPosition: data.position + 1,
                        oldPosition: data.old_position + 1,
                        newParent: data.parent,
                        oldParent: data.old_parent,
                        id: data.node.id
                    }
                };
                //disable DnD
                allowDnD = false;
                spinner.start();
                //call back-end - change tree sort in the DB
                var xhr = $.ajax({
                    type: "POST",
                    url: element.attr('btn-sort-tree'),
                    data: params,
                    dataType: 'json'
                });

                xhr.success(function(data){
                    allowDnD = true;
                });

                xhr.error(function(data){
                    allowDnD = false;
                });
                //always stop spinner on ajax done
                xhr.done(function(data){
                    spinner.stop();
                });
            });
        });
    };

    app.init(function(msg, data) {
        addEvents(data.context);
    });

    app.refresh(function(msg, data) {
        addEvents(data.context);
    });

})(BtnApp, jQuery);


