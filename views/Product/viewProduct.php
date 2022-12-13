<div class="d-flex d-flex flex-column bd-highlight">
    <form action="/product/<?= $product->getId() ?>" method="post" class="d-flex">
        <div class="p-5 flex-fill bd-highlight text-end">
            <img src="/assets/productimages/<?= $product->getImage() ?>" alt="<?= $product->getName() ?>" width="250"
                height="250">
        </div>
        <div class="p-5 flex-fill bd-highlight d-flex flex-column">
            <div class="p-2 flex-fill bd-highlight">
                <h1>
                    <?= $product->getName() ?>
                </h1>
            </div>
            <div class="p-2 flex-fill bd-highlight">
                <?= $product->getDescription() ?>
            </div>
            <div class="p-2 flex-fill bd-highlight">
                <button type="submit" class="btn btn-primary">Acheter <?= $product->getPrice() ?>€</button>
                <input type="number" min="0" name="quantity" value="1" />
            </div>
        </div>
    </form>
    <?php
    if (isset($quantityBought)) {
    ?>
    <div class=" flex-fill alert alert-success" role=" ">
        Produit ajouté <?= $quantityBought > 1 ? $quantityBought . " fois" : "" ?> au panier !
    </div>
    <?php
    }
    ?>
</div>