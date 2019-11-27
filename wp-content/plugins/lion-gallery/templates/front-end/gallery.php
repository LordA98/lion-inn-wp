<?php $tpl = new LGTemplate( __DIR__ ); ?>

<!--Carousel Wrapper-->
<div id="carousel-with-lb" class="carousel slide carousel-multi-item mt-4" data-ride="carousel">

  <!--Slides and lightbox-->

	<div class="carousel-inner row justify-content-center mr-0" role="listbox">

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

				$active = ($i==0 ? "active" : "");
				
				echo "<div class='carousel-item $active text-center col-10 pl-4 pr-0'>";

				foreach($slide as $gallery => $tn) {
					echo $tpl->render( "thumbnail", array("thumbnail" => $tn) );
				}

				echo "</div>";

				$i++;
			}

		?>

	</div>
	<!--/.Slides-->

	<!--Controls-->
	<a class="carousel-control-prev" href="#carousel-with-lb" role="button" data-slide="prev">
		<div class="bg-secondary p-2 gallery-arrow bg-secondary d-none d-lg-block">
			<span class="carousel-control-prev-icon align-middle" aria-hidden="true"></span>
		</div>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" href="#carousel-with-lb" role="button" data-slide="next">
		<div class="bg-secondary p-2 gallery-arrow bg-secondary d-none d-lg-block">
			<span class="carousel-control-next-icon align-middle" aria-hidden="true"></span>
		</div>
		<span class="sr-only">Next</span>
	</a>
	<!--/.Controls-->

</div>
<!--/.Carousel Wrapper-->