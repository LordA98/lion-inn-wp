<a href="#ps-modal" data-toggle="modal" data-target="#ps-modal" data-gallery="<?php echo $thumbnail["gallery"]; ?>">
    <figure class="col-6 col-lg-4 d-lg-inline-block figure">
        <img src="<?php echo content_url() . '/uploads/' . $thumbnail["thumbnail"]; ?>" class="img-fluid gallery-thumbnail">
        <div class="gallery-name py-3 pl-3 text-left">
            <?php echo $thumbnail["gallery"]; ?>
        </div>
    </figure>
</a>
