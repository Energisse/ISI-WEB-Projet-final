<?php
require_once("Views/Components/Product.php");

if(count($basket->getProducts()) == 0){
    echo "Le pannier est vide";
    return;
}

foreach ($basket->getProducts() as $product) {
    Product($product["product"]);
    echo $product["quantity"] . "   " . ($product["quantity"] * $product["product"]->getPrice());
}

?>
<a href="/basket/clear" class="btn btn-danger">Vider</a>
<a href="/basket/buy"  class="btn btn-primary">Acheter</a>
