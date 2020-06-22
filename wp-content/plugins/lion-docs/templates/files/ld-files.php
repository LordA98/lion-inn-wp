<?php $tpl = new LDTemplate( __DIR__ ); ?>

<table class="table table-sm table-hover table-striped">
    <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Filename</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach($files as $file) {
                echo $tpl->render( 'ld-file-row', $file ); 
            }            
        ?>
    </tbody>
</table>