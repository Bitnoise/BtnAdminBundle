/* global BtnApp, jQuery */
(function(app, $, undefined){
    'use strict';
    //diable drag and drop at start
    var allowDnD = false;
    var addEvents = function(context) {
        app.tools.findOnce('btn-jstree', context).each(function() {
            var element = $(this);
            element.jstree({
                'core': {
                    'animation' : 0,
                    'check_callback' : function (operation, node, node_parent, node_position, more) {
                        // operation can be 'create_node', 'rename_node', 'delete_node', 'move_node' or 'copy_node'
                        //if operation is move_node and node is draggable
                        if (operation === 'move_node' && node.data.jstree.draggable && allowDnD) {

                            return true;
                        };

                        return false;
                    }
                },
                // 'dnd': {
                //     'is_draggable': true
                // },
                'plugins' : ['dnd'],

            });
            if (element.attr('btn-jstree-change')) {
                element.on('changed.jstree', function (e, data) {
                    if (typeof data.node !== 'undefined' && data.node.a_attr.href !== '#' && e.target.getAttribute('btn-jstree-change') === 'reload') {
                        window.location = data.node.a_attr.href;
                    }
                });
            }
            element.on('move_node.jstree', function (e, data) {
                //ping back-end
                // console.log(data.parent);
            });
        });
    };

    var startDnD = function(context) {
        var trigger = $('[btn-jstree-startdnd]');
        $(context).on('click', trigger.selector, function() {
            allowDnD = !allowDnD;
            trigger.toggleClass('btn-success').toggleClass('btn-danger');
            //update text and btn-dnd property
            trigger.prop('btn-dnd', function(idx, oldProp) {
                $(this).text($(this).prop('btn-dnd') ? $(this).attr('btn-start-txt') : $(this).attr('btn-stop-txt'));

                return !oldProp;
            });

            return false;
        });
    };

    app.init(function(msg, data) {
        addEvents(data.context);
        startDnD(data.context);
    });

    app.refresh(function(msg, data) {
        addEvents(data.context);
    });

})(BtnApp, jQuery);


