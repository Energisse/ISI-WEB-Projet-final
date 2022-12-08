<?php
require_once("Views/Components/Product.php");
foreach ($categories as $categorie) {
    echo $categorie->getName();
?>
<div class="d-flex p-2 bd-highlight justify-content-start flex-wrap gap-4">
    <?php
    foreach ($categorie->getAllProducts() as $product) {
    ?>
    <div class="d-flex align-items-stretch">
        <?= Product($product); ?>
    </div>
    <?php
    }
    ?>
</div>
<?php
}