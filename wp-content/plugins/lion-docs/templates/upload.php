<?php

ld_log_me('Starting upload');

if ( 0 < $_FILES['file']['error'] ) {
    ld_log_me('File Upload Error');
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
}
else {
    ld_log_me('Uploading');
    move_uploaded_file($_FILES['file']['tmp_name'], '../docs/pdf/' . $_FILES['file']['name']);
}

ld_log_me('Starting upload again');

if ( 0 < $_FILES['file-upload']['error'] ) {
    ld_log_me('File Upload Error');
    echo 'Error: ' . $_FILES['file-upload']['error'] . '<br>';
}
else {
    ld_log_me('Uploading');
    move_uploaded_file($_FILES['file-upload']['tmp_name'], '../docs/pdf/' . $_FILES['file-upload']['name']);
}
