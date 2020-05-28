<form action="#" method="post" class="form-inline gallery-form">
    <i class='<?php echo $classes; ?>' data-toggle='tooltip' title='<?php echo $tooltip; ?>'></i>
    <input type="hidden" name="edit-gallery" />
    <input type="hidden" name="gallery-name" />
    <input type="hidden" name="publish-gallery" value="<?php echo $status ?>" />
    <input type="submit" class="btn <?php echo $colour; ?>" value="Toggle" />
</form>