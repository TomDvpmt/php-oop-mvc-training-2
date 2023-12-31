<?php 

$thumbnail = ROOT. self::PRODUCTS_THUMBS_DIR . $this->genericData['thumbnail'];

ob_start();?>
<br />
<a href="<?= ROOT . "products/remove?category=" . $this->genericData['category'] . "&id=" . $this->genericData['id'] ?>">Delete</a>
<?php $deleteLink = ob_get_clean(); ?>

<article class="product-card <?=$this->genericData['category']?>" id="<?=$this->genericData['id']?>">
    <img class="product-card__img" src="<?=$thumbnail?>" alt="<?=$this->genericData['name']?>">
    <h2 class="product-card__name"><?=$this->genericData['name']?></h2>
    <p class="product-card__description"><?=$this->genericData['description']?></p>
    <p class="product-card__special_features">Special features: <?=$this->genericData['special_features']?></p>
    <p class="product-card__limitations">Limitations: <?=$this->genericData['limitations']?></p>
    <?= $specificHtml?>
    <p class="product-card__price">$ <?=$this->genericData['price']?></p>
    <div class="product-card__controls">
        <a href="<?= ROOT . "products/" . $this->genericData['id'] . "?category=" . $this->genericData['category'] ?>">See details</a>
        <br />
        <a href="<?= ROOT . "cart?action=add&category=" . $this->genericData['category'] . "&id=" . $this->genericData['id'] ?>">Add to cart</a>
        <?= $deleteLink ?>
    </div>
</article>