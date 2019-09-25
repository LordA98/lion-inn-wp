/**
 * 
 */
jQuery(function($) {

    /** 
     * When $(.iconClicked) {set hidden input value ready to parent item's ID for form submission} 
     */
    function setPostVar($inputName, $caller) {
        $parentListItemId = $($caller).closest("li").data("id");
        $('input[name='+$inputName+']').val($parentListItemId);
    }

    /**
     * Handle 'Add Section' differently as no parent li
     * Get parent menu_id from URL
     */
    function setMenuId($inputName) {
        $parentMenuId = $(document).getUrlParam("menu_id");
        $('input[name='+$inputName+']').val($parentMenuId);
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
    $(".add-gallery").on("click", function() {
        $('input[name="gallery-name"]').val('');
        $('input[name="publish-gallery"]').prop('checked', true);
    });
    $(".edit-gallery").on("click", function() {
        setPostVar("edit-gallery", this);

        // Set form values to current item values
        setTextInput("gallery-name", this);
        setCheckbox("publish-gallery", ".toPublish", this);
    });
    $(".delete-gallery").on("click", function() {
        setPostVar("delete-gallery", this);
        setTextInput("gallery-name", this);
    });
    
});