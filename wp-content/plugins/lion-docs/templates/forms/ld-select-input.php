<div class="form-group row">  
    <label for="<?php echo $id; ?>" class="col-4 col-form-label"><?php echo $label; ?></label>
    <select class="col-8 custom-select" name="<?php echo $name; ?>" id="<?php echo $id; ?>">

        <!-- NOTE: This select input may need to be used for various things so be careful changing variable names -->
        <option value="0" selected>-- Select Option --</option>
        <?php 
        foreach($options as $opt) {
            echo "<option value='$opt->id'>$opt->name</option>";
        }
        ?>

    </select>
</div>