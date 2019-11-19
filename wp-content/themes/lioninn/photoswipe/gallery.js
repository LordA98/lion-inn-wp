/**
 * Handle Front-End Gallery
 */
jQuery(function($) {

    $('.figure').on('click', function() {
        // var pswpElement = document.querySelectorAll('.pswp')[0];

        // // build items array
        // var items = [
        //     {
        //         src: 'https://placekitten.com/600/400',
        //         w: 600,
        //         h: 400
        //     },
        //     {
        //         src: 'https://placekitten.com/1200/900',
        //         w: 1200,
        //         h: 900
        //     }
        // ];

        // // define options (if needed)
        // var options = {
        //     // optionName: 'option value'
        //     // for example:
        //     index: 0 // start at first slide
        // };

        // // Initializes and opens PhotoSwipe
        // var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options );
        // gallery.init();

        console.log("Initialized.");
    });


    $('.figure').on('click', function() {
        $("#gallery").text($(this).parent().data("gallery"));
        
        $.ajax({
            type: 'get',
            url: 'get-images.php',
            data: 'gallery=' + $(this).parent().data("gallery"), 
            success: function(data){
                $('#gallery-images').html(data);
            }
        });
    });
        
});
