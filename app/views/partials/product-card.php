<?php ob_start();?>
<br />
<a href="<?= ROOT . "products?action=remove&category=$this->genericData['category']&id=$this->genericData['id']" ?>">Delete</a>
<?php $deleteLink = ob_get_clean(); ?>

<article class="product-card <?=$this->genericData['category']?>" id="<?=$this->genericData['id']?>">
    <img src="<?=$this->genericData['img_url']?>" alt="<?=$this->genericData['name']?>">
    <h2 class="product-card__name"><?=$this->genericData['name']?></h2>
    <p class="product-card__description"><?=$this->genericData['description']?></p>
    <?= $specificHtml?>
    <p class="product-card__price">$ <?=$this->genericData['price']?></p>
    <div class="product-card__controls">
        <a href="<?= ROOT . "product?category=$this->genericData['category']&id=$this->genericData['id']" ?>">See details</a>
        <br />
        <a href="<?= ROOT . "cart?action=add&category=$this->genericData['category']&id=$this->genericData['id']" ?>">Add to cart</a>
        <?= $deleteLink ?>
    </div>
</article>