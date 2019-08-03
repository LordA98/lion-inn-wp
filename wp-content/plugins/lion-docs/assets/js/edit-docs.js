/**
 * JQuery to handle when the icons are clicked on the Edit Menu page.
 * Set POST var's to the data-id of it's parent section / item.
 * Also sets form values when EDIT is clicked on an item.
 * The .parent() / .sibling() paths start from the icon that was clicked.
 */
jQuery(function($) {

    /** 
     * When $(.iconClicked) {set hidden input value ready to parent item's ID for form submission} 
     */
    function setPostVar($inputName, $caller) {
        $parentListItemId = $($caller).parent().parent().attr('id');
        $('input[name='+$inputName+']').val($parentListItemId);
    }

    /**
     * Checking length of DOM item identifies if it exists
     * The span with .toPublish is only rendered if the item set to be published.
     */
    function setCheckbox($inputName, $className, $caller) {
        $checked = ($($caller).siblings($className).length)?(1):(0);
        ($checked)?($('input[name='+$inputName+']').prop('checked', true)):($('input[name='+$inputName+']').prop('checked', false));

        return $checked;
    }

    /**
     * Set text input value to $inputName
     */
    function setTextInput($inputName, $caller) {
        $value = $($caller).parent().siblings('.'+$inputName).text();
        $('input[name='+$inputName+']').val($value);
    }
    
    /**
     * Handle Add, Edit & Delete Forms
     */
    $(".upload-doc").on("click", function() {
        $('input[name="doc-name"]').val('');
        $('input[name="publish-doc"]').prop('checked', true);
    });
    $(".edit-doc").on("click", function() {
        setPostVar("edit-doc", this);

        // Set form values to current item values
        setTextInput("doc-name", this);
        setCheckbox("publish-doc", ".toPublish", this);
    });
    $(".delete-doc").on("click", function() {
        setPostVar("delete-doc", this);
    });

    
    /**
     * Print Value of Selected File
     */
    $(".custom-file-input").on("change", function() {
        $(".file-selected").html("<i>" + this.value.replace("C:\\fakepath\\",'') + "</i>");
    });
    
});