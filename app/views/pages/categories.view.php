<?php 

$title = "All our products";
$content = null;

if(isset($data["error"])) {
    ob_start();?>
    <div class="page__content categories">
        <?php require_once VIEWS_DIR . "partials/error.php" ?>
    </div>
    <?php $content = ob_get_clean();
} else {
    $categoriesHtmlArray = array_map(function($category) {
        ob_start();?>
            <div class="category-card">
                <img src="<?= $category["thumbnail"] ?>" alt="">
                <h2><?=$category["name"]?></h2>
            </div>
        <?php $categoryContent = ob_get_clean();
        return $categoryContent;
    }, $data);

    $categoriesHtml = implode("", $categoriesHtmlArray);

    ob_start();?>
        <div class="page__content categories">
            <?= $categoriesHtml ?>
        </div>
    <?php $content = ob_get_clean();
}


require_once VIEWS_DIR . "/layout.php";