<?php $tpl = new LDTemplate( __DIR__ ); ?>

<?php
  foreach($groups as $group) {
    echo "<div class='l-1 " . $group->id . "-" . $group->level . "'>";

    // This groups docs
    echo $tpl->render( 'ld-group-name', array('group' => $group));
    echo $tpl->render( 'ld-doc-list', array('docs' => $group->docs));
    
    // Subgroups docs
    foreach($group->subgroups as $sub) {
      echo "<div class='l-2 ml-2 " . $sub->id . "-" . $sub->level . "'>";
      echo $tpl->render( 'ld-group-name', array('group' => $sub));      
      echo $tpl->render( 'ld-doc-list', array('docs' => $sub->docs));

      // Sub Sub Groups docs
      foreach($sub->subgroups as $subsub) {
        echo "<div class='l-3 ml-4 " . $subsub->id . "-" . $subsub->level . "'>";
        echo $tpl->render( 'ld-group-name', array('group' => $subsub));        
        echo $tpl->render( 'ld-doc-list', array('docs' => $subsub->docs));
        echo "</div>";
      }
      echo "</div>";
    }

    echo "</div><br/><br/>";
  }
?>
