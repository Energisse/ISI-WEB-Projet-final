<?php
require_once("Views/Components/OrderProductSummary.php");
//Start 0 to "Waiting for payement"
$statusCode = $order->getStatus()->getStatusCode() - OrderStatusCode::$WaintingPayment
?>

<div class="container">
    <ul class="progressbar">
        <li class="active">
            <?= date_format($order->getStatusHistory(OrderStatusCode::$WaintingPayment)->getDate(), 'Y-m-d H:i:s') ?>
        </li>
        <li class="<?= $statusCode > 0 ? 'active' : '' ?>">
            <?= $statusCode > 0 ? date_format($order->getStatusHistory(OrderStatusCode::$Paid)->getDate(), 'Y-m-d H:i:s') : "" ?>
            <i class="fa-solid fa-credit-card"></i>
        </li>
        <li class="<?= $statusCode > 1 ? 'active' : '' ?>">
            <?= $statusCode > 1 ? date_format($order->getStatusHistory(OrderStatusCode::$InDelivery)->getDate(), 'Y-m-d H:i:s') : "" ?>
            <i class="fa-solid fa-truck-fast"></i>
        </li>
        <li class=" <?= $statusCode > 2 ? 'active' : '' ?>">
            <?= $statusCode > 2 ? date_format($order->getStatusHistory(OrderStatusCode::$Delivered)->getDate(), 'Y-m-d H:i:s') : "" ?>

            <i class="fa-solid fa-location-dot"></i>
        </li>
    </ul>
</div>
<a class="btn btn-link" href="/user/order/facture/<?= $order->getId() ?>">facture</a>

<link rel="stylesheet" href="/assets/public/styles/admin.css">