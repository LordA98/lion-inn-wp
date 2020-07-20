<?php 
$nav = new LDTemplate( __DIR__ ); 

$showhide = $id == 1 ? "show" : "hide";
?>

<div>
  <div id="<?php echo $id; ?>">
    <a class="btn btn-link p-0 level-1" data-toggle="collapse" data-target="#collapse-<?php echo $id; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $id; ?>">
      <?php echo $name; ?>
    </a>
  </div>

  <div id="collapse-<?php echo $id; ?>" class="collapse <?php echo $showhide; ?> ml-4" aria-labelledby="<?php echo $id; ?>" data-parent="#accordion">
    <span class="level-2">

      <?php 
        foreach($docs as $doc) {
          echo $nav->render('ld-nav-link', array('filename' => plugins_url() . '/lion-docs/docs/' . $doc->filename, 'title' => $doc->title));
        }

        foreach($subgroups as $sub) {
          echo '
            <span class="level-2">' . $sub->name . '</span>
            <div class="ml-4 level-3">
          ';
                
          foreach($sub->docs as $subdoc) {
            echo $nav->render("ld-nav-link", array("filename" => plugins_url() . "/lion-docs/docs/" . $subdoc->filename, "title" => $subdoc->title));
          }

          foreach($sub->subgroups as $subsub) {
            echo '
              <span class="level-3">' . $subsub->name . '</span>
              <div class="ml-4 level-4">
            ';

            foreach($subsub->docs as $subsubdoc) {
              echo $nav->render("ld-nav-link", array("filename" => plugins_url() . "/lion-docs/docs/" . $subsubdoc->filename, "title" => $subsubdoc->title));
            }

            echo '</div>';
          }
          
          echo '</div>';
        }
      ?>
    
    </span>
  </div>  

</div>
