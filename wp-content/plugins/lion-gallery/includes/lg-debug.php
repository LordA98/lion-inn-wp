<?php

/**
 * Print to debug.log file
 */
function lg_log_me($message) {
    if (WP_DEBUG === true) {
        if (is_array($message) || is_object($message)) {
            error_log(print_r($message, true));
        } else {
            error_log($message);
        }
    }
}

/**
 * Print to console in browser dev tools
 */
function lg_console_log($toPrint) {
    if(is_array($toPrint)) {
        echo "<script>console.log('" . json_encode($toPrint) . "');</script>";
    } else {
        echo "<script>console.log('" . $toPrint . "');</script>";
    }
}