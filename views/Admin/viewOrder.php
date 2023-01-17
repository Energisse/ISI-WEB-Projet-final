<?php
require_once("Views/Components/OrderProductSummary.php");

$request = ["payement", "shipment", "reception"];
$requestName = ["Valider le payement", "Valider l'envoie", "Valider la reception"];
//Start 0 to "Waiting for payement"
$statusCode = $order->getStatus()->getStatusCode() - OrderStatusCode::$WaintingPayment
?>

<div class="container">
    <ul class="progressbar">
        <li class="active">
            <?= date_format($order->getStatusHistory(OrderStatusCode::$WaintingPayment)->getDate(), 'Y-m-d H:i:s') ?>
        </li>
        <li class="<?= $statusCode > 0 ? 'active' : '' ?>">
            <?= $statusCode > 0 ? date_format($order->getStatusHistory(OrderStatusCode::$Paid)->getDate(), 'Y-m-d H:i:s')  : "" ?>
            <i class="fa-solid fa-credit-card"></i>
        </li>
        <li class="<?= $statusCode > 1 ? 'active' : '' ?>">
            <?= $statusCode > 1 ? date_format($order->getStatusHistory(OrderStatusCode::$InDelivery)->getDate(), 'Y-m-d H:i:s')  : "" ?>
            <i class="fa-solid fa-truck-fast"></i>
        </li>
        <li class=" <?= $statusCode > 2 ? 'active' : '' ?>">
            <?= $statusCode > 2 ? date_format($order->getStatusHistory(OrderStatusCode::$Delivered)->getDate(), 'Y-m-d H:i:s')  : "" ?>

            <i class="fa-solid fa-location-dot"></i>
        </li>
    </ul>
</div>
<br>
<br>
<br>
<br>
<br>
<?php

if ($statusCode < 3) {
?>
    <form method="post" action="/admin/order/<?= $request[$statusCode] . "/" . $order->getId() ?>">
        <input type="submit" class="btn btn-primary" value="<?= $requestName[$statusCode] ?>">
    </form>

<?php
}
// OrderProductSummary($order);
?>
<link rel="stylesheet" href="/assets/public/styles/admin.css">