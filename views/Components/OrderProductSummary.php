<?php

function OrderProductSummary(Order $order)
{
    foreach ($order->getOrderItems() as $item) {
?>
        <div class="container-image">
            <img alt="<?= $item->getProduct()->getName() ?>" src="/assets/productimages/<?= $item->getProduct()->getImage() ?>" width="64" height="64">
            <div class="quantity"><?= $item->getQuantity() ?></div>
        </div>
<?php
    }
}
?>
<link rel="stylesheet" href="/assets/styles/components/orderProductSummary.css">
