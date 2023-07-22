<?php

/**
 * Displays info in a readable manner.
 * 
 * @param mixed $data
 */

function show($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}