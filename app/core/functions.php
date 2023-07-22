<?php

/**
 * Displays info in a readable manner.
 * 
 * @param mixed $stuff
 */

function show($stuff) {
    echo "<pre>";
    print_r($stuff);
    echo "</pre>";
}