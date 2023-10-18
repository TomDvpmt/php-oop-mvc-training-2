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

function generateRandomId(): string {
    // $chars = implode(array_merge(range(0, 9), range("a", "z"), range("A", "Z")));
    // $chunks = [time()];
    for($i = 0 ; $i < 3 ;$i++) {
        $chunks[] = getRandomString(10);
        // $chunks[] = substr(str_shuffle($chars), 0, 10);
    }
    return implode("-", $chunks);
}


/**
 * Get a random string
 * 
 * @param int $length The string's length
 * @return string
 */

function getRandomString(int $length): string {
    $chars = implode(array_merge(range("a", "z"), range("A", "Z"), range(0, 9)));
    $shuffled = str_shuffle($chars);
    $randomString = substr($shuffled, 0, $length);
    return $randomString;
} 


/**
 * Get an array of URI data
 * 
 * @return array
 */

function getURI(): array {
    $requestURI = $_SERVER["REQUEST_URI"];
    $fullPath = str_replace("/public/", "", $requestURI);
    $noParamPath = explode("?", $fullPath)[0];
    $pathChunks = explode("/", $noParamPath);
    $base = $pathChunks[0];
    $last = end($pathChunks);
    
    $path = [
        "request" => $requestURI,
        "fullPath" => $fullPath,
        "noParamPath" => $noParamPath,
        "pathCunks" => $pathChunks,
        "base" => $base,
        "last" => $last,
    ];
    return $path;
}


/**
 * Get model name from category name
 * 
 * @return string
 */

 function getModelNameFromTableName(string $category): string {
    $model = substr($category, -1) === "s" ? substr($category, 0, -1) : $category;
    return ucfirst($model);
}
