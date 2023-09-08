<article class="product" id="<?=$this->id?>">
    <img src="<?=$this->imgUrl?>" alt="<?=$this->name?>">
    <h2 class="product__name"><?=$this->name?></h2>
    <p class="product__description"><?=$this->description?></p>
    <?= $specificHtml?>
    <p class="product__price">$ <?=$this->price?></p>
    <div class="product__controls">
        <a href="">Delete</a>
    </div>
</article>