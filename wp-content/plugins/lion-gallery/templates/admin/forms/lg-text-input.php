<div class="form-group row <?php echo (!empty($optClasses))?($optClasses):(''); ?>">  
    <label for="<?php echo $id; ?>" class="col-4 col-form-label"><?php echo $label; ?></label>
    <div class="col-8">
        <input type="text" class="form-control" id="<?php echo $id; ?>" name="<?php echo $name; ?>" placeholder="<?php echo $placeholder; ?>"/> 
    </div>
</div>
