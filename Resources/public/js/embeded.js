(function ($) {
    var collections,
        collectionSelector   = '[data-prototype]',
        addButtonSelector    = 'add-button',
        removeButtonSelector = 'remove-button'
        defaultFormsLimit    = 0;

    function addEmbededFormDeleteTrigger(formContainer, button) {
        formContainer.append(button);

        button.on('click', function(e) {
            // prevent default
            e.preventDefault();
            // remove the whole container form
            formContainer.parent('.form-row').remove();
        });
    }

    //add embeded form based on collection prototype
    function addForm(collectionHolder, newElement, regEx) {
        // Get the data-prototype
        var prototypeForm = collectionHolder.data('prototype');

        // get the new index
        var index = collectionHolder.data('index');

        // Replace regEx in the prototype's HTML to
        // instead be a number based on how many items we have
        var newFormPrototype = prototypeForm.replace(regEx, index);

        // increase the index with one for the next item
        collectionHolder.data('index', index + 1);

        // Display the form before the "Add"
        var newForm = $(newFormPrototype);
        newElement.before(newForm);

        //re-add form triggers - if prototype has embeded prototype in
        addEmbededFormTriggers(collectionSelector);

        if (BtnApp) {
            BtnApp.refresh(newForm);
        }
    }
    //add "Add" button to the end of embedded forms
    function addEmbededFormTriggers(collectionsSelector) {
        collections = $(collectionsSelector);
        //check if collection has button already - was appended
        var buttonObject;
        collections.each(function() {
            //add "remove" form button
            if ($(this).data('prototype-remove')) {
                buttonObject = $($(this).data('prototype-remove')).addClass(removeButtonSelector);
                //append "remove" button at the end of each form container - but only if doesn't exist
                $(this).find('>div').each(function() {
                    if (!$(this).find('.' + removeButtonSelector).length > 0) {
                        addEmbededFormDeleteTrigger($(this).find('>div:first'), buttonObject.clone());
                    };
                });

            };
            //created "add" button based on prototype-add
            buttonObject = $($(this).data('prototype-add')).addClass(addButtonSelector);
            if (!$(this).find('.' + buttonObject.attr('class').replace(/ /g, '.')).length > 0 && $(this).data('prototype-add')) {
                $(this).append(buttonObject);
                //set index - number of embeded forms
                $(this).data('index', $(this).find('>div').length + 1); // >div.length - this should be a number of already emeded forms
            };
        });
    }

    jQuery(document).ready(function() {

        if ($(collectionSelector).length) {

            addEmbededFormTriggers(collectionSelector);

            //handle click - add form based on embeded prototype
            $(document).on('click', '.' + addButtonSelector, function(e) {
                // prevent default behavior
                e.preventDefault();
                //prepare data for new form creation
                var parent     = $(this).parent(),
                    regEx      = new RegExp(parent.data('prototype-replacement'), 'g'),
                    formsLimit = parent.data('prototype-limit') ? parent.data('prototype-limit') : defaultFormsLimit;
                //check - add new form only if there is no limit (formsLimit ==0) or standard count check
                if (formsLimit == 0 || (formsLimit > parent.children('.form-row').length) ) {
                    // add a new form (see next code block)
                    addForm(parent, $(this), regEx);
                } else {
                    //show some limit message ?
                }
            });
        };
    });

})(jQuery);
