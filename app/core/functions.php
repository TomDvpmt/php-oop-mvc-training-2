<?php

/**
 * Displays info in a readable manner.
 * 
 * @param mixed $data
 */

function show($data) {
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}


function generateRandomId() {
    $chars = implode(array_merge(range(0, 9), range("a", "z"), range("A", "Z")));
    $chunks = [time()];
    for($i = 0 ; $i < 3 ;$i++) {
        array_push($chunks, substr(str_shuffle($chars), 0, 10));
    }
    return implode("-", $chunks);
}