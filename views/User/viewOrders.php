<?php
require_once("Views/Components/OrderProductSummary.php");
$status = ["Validation du payement", "En cours de preparation", "En cours de livraison", "Livré"]
?>
<div class="table-responsive-xxl">
    <div class="container-fluid">
        <div class="accordion accordion-flush" id="accordion">
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
                        $statusCode = $order->getStatus()->getStatusCode() - OrderStatusCode::$WaintingPayment
                    ?>
                        <tr>
                            <td> <?= date_format($order->getStatusHistory(OrderStatusCode::$WaintingPayment)->getDate(), 'Y-m-d H:i:s') ?></td>
                            <td> <?= $status[$order->getStatus()->getStatusCode() - OrderStatusCode::$WaintingPayment] ?></td>
                            <td><?= OrderProductSummary($order) ?></td>
                            <td> <?= $order->getPrice() ?> €</td>
                            <td>
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseInfo<?= $order->getId() ?>" aria-expanded="false"></button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <div id="collapseInfo<?= $order->getId() ?>" class=" accordion-collapse collapse position-relative" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                        <div class="container-fluid row  p-3">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Nom</th>
                                                        <th scope="col">Prénom</th>
                                                        <th scope="col">Téléphone</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Addresse</th>
                                                        <th scope="col">Addresse complemtaire</th>
                                                        <th scope="col">Vile</th>
                                                        <th scope="col">Code postal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?= $order->getDeliveryAddress()->getSurName() ?></td>
                                                        <td><?= $order->getDeliveryAddress()->getForeName() ?></td>
                                                        <td><?= $order->getDeliveryAddress()->getPhone() ?></td>
                                                        <td><?= $order->getDeliveryAddress()->getEmail() ?></td>
                                                        <td><?= $order->getDeliveryAddress()->getAdd1() ?></td>
                                                        <td><?= $order->getDeliveryAddress()->getAdd2() ?></td>
                                                        <td><?= $order->getDeliveryAddress()->getCity() ?></td>
                                                        <td><?= $order->getDeliveryAddress()->getPostCode() ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="container-fluid row p-3">
                                            <div class="col-sm-10">
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
                                            <div class="col-sm-2">
                                                <a class="btn btn-link" href="/user/order/facture/<?= $order->getId() ?>">facture</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<link rel="stylesheet" href="/assets/public/styles/admin.css">
<link rel="stylesheet" href="/assets/public/styles/orders.css">