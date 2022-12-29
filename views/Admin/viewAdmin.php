<?php
require_once("Views/Components/OrderProductSummary.php");

?>
<ul class="list-group">
    <?php

    foreach ($orders as $order) {
    ?>
        <li class="list-group-item">
            <?= $order->getStatusHistory()[0]->getDate() ?>
            <?php

            switch ($order->getStatus()->getStatusCode()) {
                case 0:
                    echo "En préparation";
                    break;
                case 1:
                    echo "En livraison";
                    break;
                case 2:
                    echo "Livré";
                    break;
            }
            OrderProductSummary($order);
            ?>
            <a class="btn btn-primary" href="/admin/order/<?= $order->getId()?>">Plus d'info</a>
            <a class="btn btn-link">facture</a>
        </li>
    <?php
    }
    ?>
</ul>
