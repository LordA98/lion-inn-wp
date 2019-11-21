/**
 * Handle Front-End Gallery
 */
jQuery(function($) {
    
    $('.figure').on('click', function() {        
        var data = {
            'action': 'load_images_ajax',
            gallery: $(this).parent().data("gallery")
        };

        $('.modal-title').text($(this).parent().data("gallery"));
        
        $.post(the_ajax_script.ajaxurl, data, function(response) {
            $('#gallery-images').html(response);
        });
    });
        
});
