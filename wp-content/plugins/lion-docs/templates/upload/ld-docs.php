<?php $tpl = new LDTemplate( __DIR__ ); ?>

<?php
  foreach($groups as $group) {
    // This groups docs
    // TODO: convert this into a template and add edit and delete buttons
    echo $tpl->render( 'ld-group-name', array('group' => $group, 'type' => 'group'));

    echo $tpl->render( 'ld-doc-list', array('docs' => $group->docs));
    
    // Subgroups docs
    foreach($group->subgroups as $sub) {
      echo $tpl->render( 'ld-group-name', array('group' => $sub, 'type' => 'sub'));
      
      echo $tpl->render( 'ld-doc-list', array('docs' => $sub->docs));
    }

    echo "<br/><br/>";
  }
?>
