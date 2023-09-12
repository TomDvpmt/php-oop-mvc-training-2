<article class="product-card <?=$this->category?>" id="<?=$this->id?>">
    <img src="<?=$this->imgUrl?>" alt="<?=$this->name?>">
    <h2 class="product-card__name"><?=$this->name?></h2>
    <p class="product-card__description"><?=$this->description?></p>
    <?= $specificHtml?>
    <p class="product-card__price">$ <?=$this->price?></p>
    <div class="product-card__controls">
        <a href="<?= ROOT . "product&category=$this->category&id=$this->id" ?>">See details</a>
        <br />
        <a href="<?= ROOT . "products?action=remove&category=$this->category&id=$this->id" ?>">Delete</a>
    </div>
</article>