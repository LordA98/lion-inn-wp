<?php $tpl = new LGTemplate( __DIR__ ); ?>

<!--Carousel Wrapper-->
<div id="carousel-with-lb" class="carousel slide carousel-multi-item mt-4" data-ride="carousel">

  <!--Slides and lightbox-->

	<div class="carousel-inner" role="listbox">

		<?php 

			// Split thumbnails up into array of 6 elements each (6 thumbnails per slide of carousel)
			$slides = [];
			$slides[0] = [];
			$counter = 0;
			$index = 0;
			foreach($thumbnails as $thumbnail) {
				if($counter % 6 == 0 && $counter > 0) {
					$index++;
					$slides[$index] = [];
				} 
				array_push($slides[$index], $thumbnail[0]);
				$counter = $counter+1;
			}

			// Iterate slides and print carousel
			$i=0;
			foreach($slides as $key => $slide) {

				$active = ($i==0 ? "active" : "");
				
				echo "<div class='carousel-item $active text-center'>";

				foreach($slide as $tn) {
					echo $tpl->render( "thumbnail", array("thumbnail" => $tn) );
				}

				echo "</div>";

				$i++;
			}

		?>

		<!-- Third slide-->
		<div class="carousel-item text-center">

		<figure class="col-md-3 d-md-inline-block">
			<a href="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(44).jpg"
			data-size="1600x1067">
			<img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(44).jpg"
				class="img-fluid">
			</a>
		</figure>

		<figure class="col-md-3 d-md-inline-block">
			<a href="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(45).jpg"
			data-size="1600x1067">
			<img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(45).jpg"
				class="img-fluid">
			</a>
		</figure>

		<figure class="col-md-3 d-md-inline-block">
			<a href="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(66).jpg"
			data-size="1600x1067">
			<img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(66).jpg"
				class="img-fluid">
			</a>
		</figure>

		<figure class="col-md-3 d-md-inline-block">
			<a href="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(53).jpg"
			data-size="1600x1067">
			<img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(53).jpg"
				class="img-fluid">
			</a>
		</figure>
		<figure class="col-md-3 d-md-inline-block">
			<a href="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(56).jpg"
			data-size="1600x1067">
			<img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(56).jpg"
				class="img-fluid">
			</a>
		</figure>
		<figure class="col-md-3 d-md-inline-block">
			<a href="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(77).jpg"
			data-size="1600x1067">
			<img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(77).jpg"
				class="img-fluid">
			</a>
		</figure>

		</div>
		<!--/.Third slide -->

	</div>
	<!--/.Slides-->

	<!--Controls-->
	<a class="carousel-control-prev" href="#carousel-with-lb" role="button" data-slide="prev">
		<div class="bg-secondary p-2 gallery-arrow bg-secondary">
		<span class="carousel-control-prev-icon align-middle" aria-hidden="true"></span>
		</div>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" href="#carousel-with-lb" role="button" data-slide="next">
		<div class="bg-secondary p-2 gallery-arrow bg-secondary">
		<span class="carousel-control-next-icon align-middle" aria-hidden="true"></span>
		</div>
		<span class="sr-only">Next</span>
	</a>
	<!--/.Controls-->

</div>
<!--/.Carousel Wrapper-->