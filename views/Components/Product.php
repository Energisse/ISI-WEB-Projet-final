<?php
function Product(Product $product)
{
?>
    <div class="card product">
        <a href="/product/<?= $product->getId() ?>">
            <img src="/assets/productimages/<?= $product->getImage() ?>" class="card-img-top" alt="<?= $product->getName() ?>">
            <div class="card-body">
                <h5 class="card-title">
                    <?= $product->getName() ?>
                </h5>
                <p class="card-text prix">
                    <?= $product->getPrice()  ?>€
                </p>
            </div>
        </a>

    </div>
    <link rel="stylesheet" href="/assets/styles/components/product.css">
<?php
}
