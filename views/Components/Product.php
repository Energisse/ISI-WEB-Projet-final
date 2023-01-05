<?php
function Product(Product $product)
{
?>
<div class="card" style="width: 18rem;">
    <a href="/product/<?= $product->getId() ?>">

        <img src="/assets/productimages/<?= $product->getImage() ?>" class="card-img-top"
            alt="<?= $product->getName() ?>">
        <div class="card-body flex-column  justify-content-between d-flex fle">
            <h5 class="card-title">
                <?= $product->getName() ?>
            </h5>
            <p class="card-text">
                <?= $product->getDescription() ?>
            </p>
            <p class="card-text">
                <?=$product->getPrice()  ?>€
            </p>
        </div>
    </a>

</div>
<?php
}