<?php
require_once("Views/Components/OrderProductSummary.php");

$request = ["payement","shipment","reception"];
$requestName = ["Valider le payement","Valider l'envoie","Valider la reception"];

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
<br/>
<br/>
<br/>
<br/>
<br/>
<?php

if($order->getStatus()->getStatusCode() < 3){
    ?>
    <form method="post" action="/admin/order/<?=$request[$order->getStatus()->getStatusCode()]."/".$order->getId()?>">
        <input type="submit" class="btn btn-primary" value="<?=$requestName[$order->getStatus()->getStatusCode()]?>">
    </form>

<?php
}
// OrderProductSummary($order);
?>
<link rel="stylesheet" href="/assets/styles/admin.css">