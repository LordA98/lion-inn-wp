<script>
// Open the Modal
function openModal() {
    document.getElementById("myModal").style.display = "block";
}

// Close the Modal
function closeModal() {
    document.getElementById("myModal").style.display = "none";
}

var slideIndex = 1;

// Next/previous controls
function plusSlides(n) {
    showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex-1].style.display = "block";
}

$('.modal-image-figure').on('click', function() {
    $('.modal').hide();
    $('.modal-backdrop').hide();
});

$('.modal-image').on('click', function() {
    openModal();

    var data = {
        'action': 'handle_lightbox_ajax',
        gallery: "Gallery name?" //$(this).parent().data("gallery")
    };
    
    $.post(the_ajax_script.ajaxurl, data, function(response) {
        $('#slides').html(response);
    })
    .done(function() {
        currentSlide(1);
    });
});
</script>

<style>
.modal-image-figure {
    text-align: center;
}
.modal-image-figure:hover {
    cursor: pointer;
}

.modal-image {
    height:110px; 
    width: auto;
}
</style>

<!-- TODO: currentSlide param needs to be made dynamically - possibly using array indexes -->
<figure class="col-3 modal-image-figure hover-shadow" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
    <img src="<?php echo content_url() . '/uploads/' . $post_title . "." . $post_mime_type; ?>" 
        class="modal-image" itemprop="thumbnail" />
</figure>
