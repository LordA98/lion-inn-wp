<?php 
    $tpl = new LMTemplate( __DIR__ ); 

    $name = str_replace('\\', '', $name);    
?>

<div class="sub-item row">
    <div class="col-6 col-md-8 col-lg-5 col-xl-6 pr-0">
        <p><?php echo $name; ?></p>
    </div>
    <div class="col-3 col-md-2 col-lg-3 col-xl-3 px-0"></div>
    <div class="col-3 col-md-2 pr-0 text-center text-md-right">
        <?php 
        if((!is_null($price)) && ($price !== "0.00")) {
            $price = number_format((float) $price, 2);
            echo "<p class='sub-price mr-3'>";
            if($price >= 1.00) {
                echo "£$price";
            } else {
                // Multiply by 100 so display without prefix 0.
                echo "+" . $price * 100 . "p";
            }
            echo "</p>";
        }
        ?>
    </div>
</div>
