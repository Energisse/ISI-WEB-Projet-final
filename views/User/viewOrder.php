<?php
require_once("Views/Components/OrderProductSummary.php");
?>

<div class="container">
    <ul class="progressbar">
    <li class="active">
            <?= $order->getStatusHistory()[0]->getDate() ?>
        </li>
        <li class="<?= $order->getStatus()->getStatusCode() > 0 ? "active" : "" ?>">
            <?= $order->getStatus()->getStatusCode() > 0 ? $order->getStatusHistory()[1]->getDate() : "" ?>

            <i class="fa-solid fa-credit-card"></i>
        </li>
        <li class="<?= $order->getStatus()->getStatusCode() > 1 ? "active" : "" ?> ">
            <?= $order->getStatus()->getStatusCode() > 1 ? $order->getStatusHistory()[2]->getDate() : "" ?>
            <i class="fa-solid fa-truck-fast"></i>
        </li>
        <li class=" <?= $order->getStatus()->getStatusCode() > 2 ? "active" : "" ?> ">
            <?= $order->getStatus()->getStatusCode() > 2 ? $order->getStatusHistory()[3]->getDate() : "" ?>

            <i class="fa-solid fa-location-dot"></i>
        </li>
    </ul>
</div>  
<link rel="stylesheet" href="/assets/styles/admin.css">