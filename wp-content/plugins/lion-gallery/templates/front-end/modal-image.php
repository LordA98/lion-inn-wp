<script>
$(function () {
    $('[data-fancybox="gallery"]').fancybox({
        loop: true,
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

<figure class="col-3 modal-image-figure" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
    <a href="<?php echo content_url() . '/uploads/' . $post_title . "." . $post_mime_type; ?>" data-fancybox="gallery">
        <img src="<?php echo content_url() . '/uploads/' . $post_title . "." . $post_mime_type; ?>" 
            class="modal-image" itemprop="thumbnail" />
    </a>
</figure>