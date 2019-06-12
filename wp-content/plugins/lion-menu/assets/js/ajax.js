jQuery(function($) {

    $('.menu-form').submit(function(event) {
        var form_data = $(this).serialize();
        console.log(form_data);

        var data = {
            'action': 'handle_ajax',
            form_data: form_data
        };
        
        $.post(ajaxurl, data, function(response) {
            console.log(data);
            
            // Confirmation Messages Here

            location.reload();
        });

        return false;
    });
    
});