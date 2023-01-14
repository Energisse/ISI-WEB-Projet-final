<?php
require_once("Views/Components/OrderProductSummary.php");
$status = ["Validation du payement", "En cours de preparation", "En cours de livraison", "Livré"]
?>
<div class="table-responsive-xxl">
    <div class="container-fluid">
        <h1>Liste de vos commandes</h1>
        <table class="table align-middle">
            <thead>
                <tr>
                    <th scope="col">Date d'achat</th>
                    <th scope="col">Etat</th>
                    <th scope="col">Produits</th>
                    <th scope="col">Prix</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($orders as $order) {
                ?>
                    <tr>
                        <td> <?= date_format($order->getStatusHistory(OrderStatusCode::$WaintingPayment)->getDate(), 'Y-m-d H:i:s') ?></td>
                        <td> <?= $status[$order->getStatus()->getStatusCode() - OrderStatusCode::$WaintingPayment] ?></td>
                        <td><?= OrderProductSummary($order) ?></td>
                        <td> <?= $order->getPrice() ?> €</td>
                        <td><a class="btn btn-primary" href="/user/order/<?= $order->getId() ?>">Plus d'info</a>
                            <a class="btn btn-link">facture</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>