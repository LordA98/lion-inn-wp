<?php 
    $description = str_replace('\\', '', $description);
?>

<div class="tab-pane fade show <?php echo ($isActive == 0 ? 'active' : ''); ?> my-4" id="<?php echo strtolower($day); ?>" role="tabpanel" aria-labelledby="<?php echo strtolower($day); ?>-tab">
    <h3><?php echo $title; ?></h3>
    <div class="description"><?php echo $description; ?></div>
</div>