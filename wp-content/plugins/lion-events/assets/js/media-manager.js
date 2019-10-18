/**
 * Scripts to manage the media functionality in the events plugin.
 * Used to select / change images used for events.
 */
jQuery(function($) {

    /**
     * Add Event Media Modal
     */
    $('#add-event-image-select').on('click', function() {
        var images = wp.media({
            title: "Select Event Image",
            multiple: false
        }).open().on('select', function(e) {
            var selectedImage = images.state().get('selection').first();
            selectedImage = selectedImage.toJSON();            

            // Strip url so we only have the last part
            var url_segments = selectedImage.url.split("/");
            var image_url = url_segments.pop(); 

            var height = selectedImage.height;
            var width = selectedImage.width;

            // Set url, height and width as value of hidden input values ready for POST request to add to DB
            $('input[name="add-event-image"').val(image_url);
            $('input[name="add-event-img-height"').val(height);
            $('input[name="add-event-img-width"').val(width);
            $('#add-image-selected-name').text(image_url);
        });

        // Change to media library tab
        // $('.media-menu-item').toggleClass('active');
        // Set filter to only event images - 'Events' category has a value of '11' for some reason
        $("select#media-attachment-filters").val("5").change();
        // Hide selects so user cannot change filter
        $("div.media-toolbar-secondary").hide();
        // Hide 'Upload Media' & 'Select Media' tabs - we only want selecting media
        $('.media-router').hide();
        // Hide right-sidebar (contains selected images details) as it isn't really needed
        $('.media-sidebar').hide();
    });

    /**
     * Edit Event Media Modal
     */
    $('#edit-event-image-select').on('click', function() {
        var images = wp.media({
            title: "Select Event Image",
            multiple: false
        }).open().on('select', function(e) {
            var selectedImage = images.state().get('selection').first();
            selectedImage = selectedImage.toJSON();

            // Strip url so we only have the last part
            var url_segments = selectedImage.url.split("/");
            var image_url = url_segments.pop();

            var height = selectedImage.height;
            var width = selectedImage.width;

            // Set url, height and width as value of hidden input values ready for POST request to add to DB
            $('input[name="edit-event-image"').val(image_url);
            $('input[name="edit-event-img-height"').val(height);
            $('input[name="edit-event-img-width"').val(width);
            $('#edit-image-selected-name').text(image_url);         
        });

        // Change to media library tab
        //$('.media-menu-item').toggleClass('active');
        // Set filter to only event images - 'Events' category has a value of '11' for some reason
        $("select#media-attachment-filters").val("5").change();
        // Hide selects so user cannot change filter
        $("div.media-toolbar-secondary").hide();
        // Hide 'Upload Media' & 'Select Media' tabs - we only want selecting media
        $('.media-router').hide();
        // Hide right-idebar (contains selected images details) as it isn't really needed
        $('.media-sidebar').hide();
    });


    /**
     * Edit Regular Event Icon Media Modal
     * Open media library manager and handle selected image
     * Filter only icons and prevent the ability to change the filter
     */
    $('#edit-event-icon-select').on('click', function() {
        var images = wp.media({
            title: "Select Event Icon",
            multiple: false
        }).open().on('select', function(e) {            
            var selectedImage = images.state().get('selection').first();
            selectedImage = selectedImage.toJSON();

            // Strip url so we only have the last part
            var url_segments = selectedImage.url.split("/");
            var image_url = url_segments.pop();

            // Set url, height and width as value of hidden input values ready for POST request to add to DB
            $('input[name="edit-event-icon"').val(image_url);
            $('#edit-icon-selected-name').text(image_url);
        });

        // Change to media library tab
        //$('.media-menu-item').toggleClass('active');
        // Set filter to only icons - 'Icons' category has a value of '10' for some reason
        $("select#media-attachment-filters").val("6").change();
        // Hide selects so user cannot change filter
        $("div.media-toolbar-secondary").hide();
        // Hide 'Upload Media' & 'Select Media' tabs - we only want selecting media
        $('.media-router').hide();
        // Hide right-idebar (contains selected images details) as it isn't really needed
        $('.media-sidebar').hide();
    });

});