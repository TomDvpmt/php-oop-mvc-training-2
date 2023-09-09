<article class="product <?=$this->type?>" id="<?=$this->id?>">
    <img src="<?=$this->imgUrl?>" alt="<?=$this->name?>">
    <h2 class="product__name"><?=$this->name?></h2>
    <p class="product__description"><?=$this->description?></p>
    <?= $specificHtml?>
    <p class="product__price">$ <?=$this->price?></p>
    <div class="product__controls">
        <a href="<?= ROOT . $this->type . "s/remove?id=" . $this->id ?>">Delete</a>
    </div>
</article>