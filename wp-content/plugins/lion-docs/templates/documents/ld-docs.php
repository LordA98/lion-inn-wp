<?php $tpl = new LDTemplate( __DIR__ ); ?>

<?php
  foreach($groups as $group) {
    echo "<div class='" . $group->id . "'>";

    // This groups docs
    echo $tpl->render( 'ld-group-name', array('group' => $group, 'type' => 'group'));

    echo $tpl->render( 'ld-doc-list', array('docs' => $group->docs));
    
    // Subgroups docs
    foreach($group->subgroups as $sub) {
      echo $tpl->render( 'ld-group-name', array('group' => $sub, 'type' => 'sub'));
      
      echo $tpl->render( 'ld-doc-list', array('docs' => $sub->docs));

      // Sub Sub Groups docs
      foreach($sub->subgroups as $subsub) {
        echo $tpl->render( 'ld-group-name', array('group' => $subsub, 'type' => 'sub'));
        
        echo $tpl->render( 'ld-doc-list', array('docs' => $subsub->docs));
        
      }
    }

    echo "</div><br/><br/>";
  }
?>
