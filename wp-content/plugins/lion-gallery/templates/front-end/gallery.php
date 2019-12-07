<?php $tpl = new LGTemplate( __DIR__ ); ?>

<!--Carousel Wrapper-->
<div id="carousel-with-lb" class="carousel slide carousel-multi-item mt-4" data-ride="carousel">

	<!--Controls-->
	<div class="controls-top d-flex justify-content-center mb-4">
		<div>
			<a class="p-2 mr-1 gallery-arrow rounded-circle" href="#carousel-with-lb" data-slide="prev">
				<i class="fa fa-arrow-left"></i>
			</a>
		</div>
		<div>
			<a class="p-2 ml-1 gallery-arrow rounded-circle" href="#carousel-with-lb" data-slide="next">
				<i class="fa fa-arrow-right"></i>
			</a>
		</div>
	</div>
  	<!--/.Controls-->

  	<!--Carousel Slides-->
	<div class="carousel-inner row mx-0" role="listbox">

		<?php 

			// Split thumbnails up into array of 6 elements each (6 thumbnails per slide of carousel)
			$slides = [];
			$slides[0] = [];
			$counter = 0;
			$index = 0;
			foreach($thumbnails as $gallery => $thumbnail) {
				if($counter % 6 == 0 && $counter > 0) {
					$index++;
					$slides[$index] = [];
				} 
				array_push($slides[$index], array("gallery" => $gallery, "thumbnail" => $thumbnail[0]));
				$counter = $counter+1;
			}

			// Iterate slides and print carousel
			$i=0;
			foreach($slides as $key => $slide) {

				// set first carousel to active
				$active = ($i==0 ? "active" : "");
				
				echo "<div class='carousel-item $active text-center'>";

				foreach($slide as $gallery => $tn) {
					echo $tpl->render( "thumbnail", array("thumbnail" => $tn) );
				}

				echo "</div>";

				$i++;
			}

		?>

	</div>
	<!--/.Slides-->	

</div>
<!--/.Carousel Wrapper-->