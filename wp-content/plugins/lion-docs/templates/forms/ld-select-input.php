<div class="form-group row">  
    <label for="<?php echo $id; ?>" class="col-4 col-form-label"><?php echo $label; ?></label>
    <select class="col-8 custom-select" name="<?php echo $name; ?>">

        <?php if($options == "sections") { ?>
        
            <option selected>-- Select Section --</option>
            <option value="general">General</option>
            <option value="menu">Menu</option>
            <option value="events">Events</option>
            <option value="gallery">Gallery</option>

        <?php } else { ?>

            <option value="0" selected>-- Select Doc --</option>
            <?php foreach($options as $doc) ?>
                <option value="<?php echo $doc->id; ?>"><?php echo $doc->title; ?></option>

        <?php } ?>

    </select>
</div>