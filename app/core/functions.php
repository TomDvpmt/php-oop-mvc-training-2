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

/**
 * Generate a random alphanumeric id 
 * 
 * Characters range : digits + lower letters + upper letters
 * 
 * @return string A concatenated string of 1 timestamp & 3 chunks of 10 random characters, all separated with dashes
 */

function generateRandomId() {
    $chars = implode(array_merge(range(0, 9), range("a", "z"), range("A", "Z")));
    $chunks = [time()];
    for($i = 0 ; $i < 3 ;$i++) {
        array_push($chunks, substr(str_shuffle($chars), 0, 10));
    }
    return implode("-", $chunks);
}