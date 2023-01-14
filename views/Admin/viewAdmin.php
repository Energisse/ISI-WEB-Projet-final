<?php
require_once("Views/Components/OrderProductSummary.php");

?>
<ul class="list-group">
    <?php

    foreach ($orders as $order) {
    ?>
        <li class="list-group-item">
            <?= date_format($order->getStatusHistory(OrderStatusCode::$WaintingPayment)->getDate(), 'Y-m-d H:i:s') ?>
            <?php

            switch ($order->getStatus()->getStatusCode() - OrderStatusCode::$WaintingPayment) {
                case 0:
                    echo "En attente de payement";
                    break;
                case 1:
                    echo "En attente d'envoie";
                    break;
                case 2:
                    echo "En attente de livraison";
                    break;
            }
            OrderProductSummary($order);
            ?>
            <a class="btn btn-primary" href="/admin/order/<?= $order->getId() ?>">Plus d'info</a>
            <a class="btn btn-link">facture</a>
        </li>
    <?php
    }
    ?>
</ul>