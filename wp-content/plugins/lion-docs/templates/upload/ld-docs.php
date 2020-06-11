<?php $tpl = new LDTemplate( __DIR__ ); ?>

<?php
  foreach($groups as $group) {
    // This groups docs
    echo '
      <div class="row">
        <div class="align-self-center mx-3">
          <span class="badge badge-success my-auto">Group</span>
        </div>
        <div><h2 class="group-name d-inline">' . $group->name . '</h2></div>
      </div>
    ';

    echo $tpl->render( 'ld-doc-list', array('docs' => $group->docs));
    
    // Subgroups docs
    foreach($group->subgroups as $sub) {
      echo '
        <div class="row">
          <div class="align-self-center mx-3">
            <span class="badge badge-primary my-auto">Subgroup</span>
          </div>
          <div><h4 class="group-name d-inline">' . $sub->name . '</h4></div>
        </div>
      ';
      
      echo $tpl->render( 'ld-doc-list', array('docs' => $sub->docs));
    }

    echo "<br/><br/>";
  }
?>
