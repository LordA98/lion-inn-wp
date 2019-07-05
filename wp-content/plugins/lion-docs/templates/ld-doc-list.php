<?php $tpl = new LDTemplate( __DIR__ ); ?>

<table class="table table-sm table-hover">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Document Name</th>
            <th scope="col">Filename</th>
            <th scope="col">Section</th>
            <th scope="col">Parent Document</th>
            <th scope="col">Views</th>
            <th scope="col">Published</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach($docs as $doc) {
                echo $tpl->render( 'ld-doc-list-row', $doc ); 
            }            
        ?>
    </tbody>
</table>