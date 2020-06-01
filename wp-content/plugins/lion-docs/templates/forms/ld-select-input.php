<div class="form-group row">  
    <label for="<?php echo $id; ?>" class="col-4 col-form-label"><?php echo $label; ?></label>
    <select class="col-8 custom-select" name="<?php echo $name; ?>" id="<?php echo $id; ?>">

        <!-- TODO:LThis may need to be made more flexible if a select input is required that is not for listing groups -->
        <option value="0" selected>-- Select Group --</option>
        <?php 
        foreach($options as $doc) {
            echo "<option value='$doc->id'><?php echo $doc->title; ?></option>";
        }
        ?>

    </select>
</div>