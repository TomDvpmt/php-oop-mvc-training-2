<?php ob_start();?>
<br />
<a href="<?= ROOT . "products?action=remove&category=$this->category&id=$this->id" ?>">Delete</a>
<?php $deleteLink = ob_get_clean(); ?>

<article class="product-card <?=$this->category?>" id="<?=$this->id?>">
    <img src="<?=$this->imgUrl?>" alt="<?=$this->name?>">
    <h2 class="product-card__name"><?=$this->name?></h2>
    <p class="product-card__description"><?=$this->description?></p>
    <?= $specificHtml?>
    <p class="product-card__price">$ <?=$this->price?></p>
    <div class="product-card__controls">
        <a href="<?= ROOT . "product&category=$this->category&id=$this->id" ?>">See details</a>
        <br />
        <a href="<?= ROOT . "cart?action=add&category=$this->category&id=$this->id" ?>">Add to cart</a>
        <?= $deleteLink ?>
    </div>
</article>