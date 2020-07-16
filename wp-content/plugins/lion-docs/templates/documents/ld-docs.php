<?php $tpl = new LDTemplate( __DIR__ ); ?>

<?php
  foreach($groups as $group) {
    echo "<div class='" . $group->id . "'>";

    // This groups docs
    echo $tpl->render( 'ld-group-name', array('group' => $group));

    echo $tpl->render( 'ld-doc-list', array('docs' => $group->docs));
    
    // Subgroups docs
    foreach($group->subgroups as $sub) {
      echo "<div class='ml-2'>";
      echo $tpl->render( 'ld-group-name', array('group' => $sub));
      
      echo $tpl->render( 'ld-doc-list', array('docs' => $sub->docs));
      echo "</div>";

      // Sub Sub Groups docs
      foreach($sub->subgroups as $subsub) {
        echo "<div class='ml-4'>";
        echo $tpl->render( 'ld-group-name', array('group' => $subsub));
        
        echo $tpl->render( 'ld-doc-list', array('docs' => $subsub->docs));
        echo "</div>";
      }
    }

    echo "</div><br/><br/>";
  }
?>
