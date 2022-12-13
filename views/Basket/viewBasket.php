<?php
require_once("Views/Components/Product.php");

foreach ($basket->getProducts() as $product) {
    Product($product["product"]);
    echo $product["quantity"] . "   " . ($product["quantity"] * $product["product"]->getPrice());
}
?>
<a href="/basket/clear">Clear</a>