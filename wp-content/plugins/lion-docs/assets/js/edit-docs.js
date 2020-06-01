/**
 * JQuery to handle when the icons are clicked on the Edit Menu page.
 * Set POST var's to the data-id of it's parent section / item.
 * Also sets form values when EDIT is clicked on an item.
 * The .parent() / .sibling() paths start from the icon that was clicked.
 */
jQuery(function ($) {

    /** 
     * When $(.iconClicked) {set hidden input value ready to parent item's ID for form submission} 
     */
    function setPostVar($inputName, $caller) {
        $parentListItemId = $($caller).parent().parent().attr('id');
        $('input[name=' + $inputName + ']').val($parentListItemId);
    }

    /**
     * Check value of hidden div 
     * Tick publish checkbox if 1, leave unticked if 0
     */
    function setCheckbox($parentClassName, $childClassName, $caller) {
        $checked = $($caller).parent().siblings("." + $parentClassName).children("." + $childClassName).text();
        (Number($checked)) ? ($('input[name=' + $parentClassName + ']').prop('checked', true)) : ($('input[name=' + $parentClassName + ']').prop('checked', false));

        return $checked;
    }

    /**
     * Set text input value to $inputName
     */
    function setTextInput($inputName, $caller) {
        $value = $($caller).parent().siblings('.' + $inputName).text();
        $('input[name=' + $inputName + ']').val($value);
    }

    /**
     * Set currently selected file
     */
    function setFile($inputName, $caller) {
        $value = $($caller).parent().siblings(".filename").text();
        if ($value == "") {
            $value = "No file selected..."
        }
        $(".file-selected").html("<i>" + $value + "</i>");
    }

    /**
     * Set select input (dropdown)
     */
    function setSelectInput($inputId, $currentValueHolder, $caller) {
        $value = $($caller).parent().siblings("." + $currentValueHolder).text();
        $('#' + $inputId + ' option[value=' + $value + ']').prop('selected', true);
    }

    /**
     * Handle Add, Edit & Delete Forms
     */
    $(".upload-doc").on("click", function () {
        $('input[name="doc-name"]').val('');
        $('input[name="publish-doc"]').prop('checked', true);
    });
    $(".edit-doc").on("click", function () {
        setPostVar("edit-doc", this);

        // Set form values to current item values
        setTextInput("doc-name", this);
        setSelectInput("section-select-input", "section", this);
        setSelectInput("parent-doc-select-input", "parent-doc", this);
        setFile("file-upload", this);
        setCheckbox("publish-doc", "publish-value", this);
    });
    $(".delete-doc").on("click", function () {
        setPostVar("delete-doc", this);
    });

    /**
     * Print Value of Selected File
     */
    $(".custom-file-input").on("change", function () {
        $(".file-selected").html("<i>" + this.value.replace("C:\\fakepath\\", '') + "</i>");
    });


    /**
     * Handle Group Related Forms
     */
    $(".create-group").on("click", function () {
        $('input[name="group-name"]').val('');
        $('input[name="is-sub-group"]').prop('checked', false);
        $('#parent-group').hide();
        $('#parent-group').val("0");
        $('input[name="publish-doc"]').prop('checked', true);
    });
    /**
     * Toggle Parent Group select input when isSubGroup checkbox is selected
     */
    $("#is-sub-check").click(function () {
        $("#parent-group").toggle(this.unchecked);
    });

});