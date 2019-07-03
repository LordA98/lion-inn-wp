jQuery(function($) {

    /**
     * Set notification message
     */
    if(sessionStorage.getItem('docs-message')) {
        $('#docs-message-content').html(sessionStorage.getItem('docs-message'));
        sessionStorage.removeItem('docs-message');
    } else {
        $('#docs-message').hide();
    }

    /**
     * Completely close message alert when 'x' is clicked
     */
    $('.close').click(function() {
        $('#docs-message').hide();
    });

    /**
     * Validate file on selection
     */
    $(':file').on('change', function () {
        var file = this.files[0];

        if(file.name.indexOf(' ') >= 0) {
            alert('ERROR :- Rename the file.  No spaces allowed in filename.');
            console.log('ERROR :- Rename the file.  No spaces allowed in filename.');
        }
    });

    /**
     * Handle submit of any menu form using AJAX
     */
    $('.doc-form').submit(function() {
        var form_data = $(this).serialize();

        var file = $('#file-upload-input').prop('files')[0];
        form_data += '&file-upload=' + file.name;

        // Upload file
        // var file_data = $('#sortpicture').prop('files')[0];   
        // var form_data = new FormData();
        // form_data.append('file', file_data);
        $.ajax({
            url: '../../wp-content/plugins/lion-docs/templates/upload.php', // point to server-side PHP script 
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(response){
                console.log(response); // display response from the PHP script, if any
            }
        });


        console.log(form_data);

        var data = {
            'action': 'handle_ajax_docs',
            form_data: form_data
        };
        
        $.post(ajaxurl, data, function(response) {
            console.log(response);

            sessionStorage.setItem('docs-message', response);

            window.location.reload();
        });

        return false;
    });
    
});