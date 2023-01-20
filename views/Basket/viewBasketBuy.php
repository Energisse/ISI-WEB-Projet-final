<?php
require_once 'Models/DeliveryAddress.php';
require_once 'views/Components/OrderSummary.php';
?>

<?php
if (!$order->getOrderItems()) {
?>
    <h1>
        Votre panier est vide!
    </h1>
<?php
    return;
}
if ($productAdded) {
?>
    <div class=" flex-fill alert alert-danger">
        Produit rajouté, commande modifié !
    </div>
<?php
}
?>
<form method="post" class="d-flex flex-row" id="basket-buy">
    <div class="col">
        <div class="container-xxl">
            <h1>Liste de vos addresses</h1>
            <div class="table-responsive-xxl">
                <table class="table align-middle" id="addresses-table">
                    <thead>
                        <tr>
                            <th scope=" col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Téléphone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Addresse</th>
                            <th scope="col">Addresse complemtaire</th>
                            <th scope="col">Vile</th>
                            <th scope="col">Code postal</th>
                            <th scope="col">Modifier</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($deliveryAddresses as $deliveryAddress) {
                        ?>
                            <label>
                                <tr>
                                    <td><?= $deliveryAddress->getSurName() ?></td>
                                    <td> <?= $deliveryAddress->getForeName() ?></td>
                                    <td><?= $deliveryAddress->getPhone() ?></td>
                                    <td><?= $deliveryAddress->getEmail() ?></td>
                                    <td><?= $deliveryAddress->getAdd1() ?></td>
                                    <td><?= $deliveryAddress->getAdd2() ?></td>
                                    <td><?= $deliveryAddress->getCity() ?></td>
                                    <td><?= $deliveryAddress->getPhone() ?></td>
                                    <td>
                                        <a class="btn btn-primary" href="/address/<?= $deliveryAddress->getId() ?>">Modifier</a>
                                    </td>
                                    <td>
                                        <input class="form-check-input radio-address" type="radio" name="address" value="<?= $deliveryAddress->getId() ?>">
                                    </td>
                                </tr>
                            </label>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a href="/address?goTo=/basket" class="btn btn-link">Ajouter une addresse</a>
            </div>
        </div>
        <div class="container-xxl">
            <h1>Facturation</h1>

            <label class="form-check-label">
                <input class="form-check-input radio-payement" type="radio" name="payement" value="moneyCheck">
                <i class="fa-solid fa-money-check fa-2xl"></i>
                Cheque
            </label>


            <label class="form-check-label">
                <input class="form-check-input radio-payement" type="radio" name="payement" value="paypal">
                <i class="fa-brands fa-paypal fa-2xl"></i>
                Paypal
            </label>

            <label class="form-check-label">
                <input class="form-check-input radio-payement" type="radio" name="payement" value="creditCard">
                <i class="fa-solid fa-credit-card fa-2xl"></i>
                Carte bancaire
            </label>
            </br></br>
            <input type="submit" class="btn btn-primary" value="Payer" />
            <a href="/basket/clear" class="btn btn-danger">Vider</a>
        </div>
    </div>

    <?= OrderSummary($order) ?>
</form>
<script src="/assets/public/scripts/basket.js"></script>
<link rel="stylesheet" href="/assets/public/styles/basket.css">