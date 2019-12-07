<a href="#gallery-modal" data-toggle="modal" data-target="#gallery-modal" data-gallery="<?php echo $thumbnail["gallery"]; ?>">
    <figure class="col-12 col-md-5 col-lg-3 figure p-0 mr-md-3 ml-md-3">
        <img src="<?php echo content_url() . '/uploads/' . $thumbnail["thumbnail"]; ?>" class="img-fluid gallery-thumbnail">
        <div class="gallery-name py-3 pl-3 text-left">
            <?php echo $thumbnail["gallery"]; ?>
        </div>
    </figure>
</a>
