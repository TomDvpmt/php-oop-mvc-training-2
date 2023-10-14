<?php 

$category = $this->category;
$title = ucfirst($category);

if(isset($data["error"])) {
    ob_start();
        require_once VIEWS_DIR . "partials/error.php";
    $result = ob_get_clean();
} else {
    $result = implode($data);
}

ob_start();?>
<div class="page__content category">
    <section class="category__sidebar"></section>
    <section class='category__grid'><?= $result ?></section>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";