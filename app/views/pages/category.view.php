<?php 

$category = $this->category;
$title = ucfirst($category);

ob_start();?>
<div class="page__content category">
    <section class="category__sidebar"></section>
    <section class='category__grid'><?= implode($data) ?></section>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . "/layout.php";