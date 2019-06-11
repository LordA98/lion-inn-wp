jQuery(function($) {

    $('#edit-item-form').submit(function() {
        var data = {
            'action': 'my_action',
            'whatever': ajax_object.we_value      // We pass php values differently!
        };
        // We can also pass the url value separately from ajaxurl for front end AJAX implementations
        $.post(ajax_object.ajax_url, data, function(response) {
            console.log('Got this from the server: ' + response);
        });
    });
    

});