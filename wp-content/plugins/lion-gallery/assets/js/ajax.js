jQuery(function ($) {

    /**
     * Set notification message
     */
    if (sessionStorage.getItem('galleryMessage')) {
        $('#lg-message-content').html(sessionStorage.getItem('galleryMessage'));
        sessionStorage.removeItem('galleryMessage');
    } else {
        $('#lg-message').hide();
    }

    /**
     * Completely close message alert when 'x' is clicked
     */
    $('.close').click(function () {
        $('#lg-message').hide();
    });

    /** 
     * When toggle is clicked - set hidden var for post
     */
    function setPostVar($inputName, $caller) {
        $parentListItemId = $($caller).closest("tr").attr("id");
        $('input[name=' + $inputName + ']').val($parentListItemId);
    }

    /**
     * Set gallery name on toggle submission
     */
    function setGalleryName($inputName, $caller) {
        $galleryName = $($caller).parent().siblings("td.gallery-name").text();
        $('input[name=' + $inputName + ']').val($galleryName);
    }

    /**
     * Handle submit of any menu form using AJAX
     */
    $('.gallery-form').submit(function () {
        setPostVar("edit-gallery", this);
        setGalleryName("gallery-name", this);

        var form_data = $(this).serialize();

        console.log(form_data);

        var data = {
            'action': 'handle_ajax_lg',
            form_data: form_data
        };

        // console.log(data);

        $.post(ajaxurl, data, function (response) {
            sessionStorage.setItem('galleryMessage', response);

            window.location.reload();
        });

        return false;
    });

});