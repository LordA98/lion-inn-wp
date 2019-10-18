<?php $name = str_replace('\\', '', $name); ?>

<li class="nav-item <?php echo $classes; ?> col-lg p-0">
    <a class="nav-link p-0 d-flex flex-column <?php if($isFirst) { echo "show active"; } ?>" id="<?php echo strtolower($name); ?>-tab" data-toggle="tab" href="#<?php echo strtolower($name); ?>" role="tab" aria-controls="<?php echo strtolower($name); ?>" aria-selected="true">
        <h4 class="m-0 my-auto"><?php echo $name; ?></h4>
    </a>
</li>