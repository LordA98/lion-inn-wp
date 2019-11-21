# How the Gallery Works in the Front-End

The themes calls the function like so:

`$lionGallery->render_galleries();`

This `render_galleries` function gets all the images from the WPDB, organises them into their folders,
and then retains 1 image from each folder / gallery to be used as a thumbnail.

It then renders the `gallery` template (passing in these thumbnails as an array parameter).

The `gallery` template renders a Bootstrap carousel which uses a PHP script to show these thumbnails
in 2 rows of 3 images each.  Keeping only 6 total thumbnails per slide.

The `gallery` template renders a `thumbnail` template for each thumbnail in the array.  This refers to the 
thumbnail and title overlay at the bottom of each thumbnail.

When any of these thumbnail items is clicked, the JavaScript in the `themes/lioninn/gallery.js` code executes.
Each of these thumbnail items has a `figure` element with a `.figure` class.

This opens a modal (`modal.php` in the `front-end templates folder` of the lion-gallery plugin.).
It simultaneously performs an AJAX request to the `load_images_ajax` function defined in the `themes/lioninn/functions.php` file.

This executes the `$lionGallery->render_images();` function.  This function gets all images for that specific gallery
from the WPDB, deals with the extensions and then prints each image in the modal using the `modal-image` template.

The `modal-image` template contains HTML markup for each image in the Bootstrap modal, as well as CSS styling
and JavaScript code which initializes the FancyBox lightbox to be used when a user clicks on an image in the modal.

This opens a fullscreen lightbox to view the images at a larger scale.

It's not ideal keeping the HTML, CSS and JS in the same file but it's easier to manage and ensure it works.