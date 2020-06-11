<?php $tpl = new LDTemplate( __DIR__ ); ?>

<table class="table table-sm table-hover table-striped">
    <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Document Name</th>
            <th scope="col">Filename</th>
            <th scope="col">Published</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
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