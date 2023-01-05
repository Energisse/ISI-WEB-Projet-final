<?php
require_once 'Models/DeliveryAddress.php';
?>
<form method="post">
    <h1>Addresse de livraison</h1>
    <div class="container">
        <div class="accordion" id="accordionAddresses">

            <?php
            foreach ($deliveryAddresses as $deliveryAddress) {
            ?>
                <div class="row">
                    <div data-bs-toggle="collapse" data-bs-target="#collapse<?= $deliveryAddress->getId() ?>" aria-expanded="true" aria-controls="collapseOne">

                        <label class="form-check-label">
                            <input class="form-check-input radio-address" type="radio" name="address" value="<?= $deliveryAddress->getId() ?>">
                            <!-- <i class="fa-solid fa-location-dot"></i> -->
                            <?= $deliveryAddress->getForeName() ?>
                            <?= $deliveryAddress->getSurName() ?>,


                            <?= $deliveryAddress->getCity() ?>,
                            <?= $deliveryAddress->getPostCode() ?>,

                        </label>
                    </div>
                    <div id="collapse<?= $deliveryAddress->getId() ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionAddresses">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-6 col-md-4">
                                    <p><strong>Nom :</strong> <?= $deliveryAddress->getForeName() ?></p>
                                    <p><strong>Email :</strong> <?= $deliveryAddress->getEmail() ?></p>
                                    <p><strong>Addresse 1 :</strong><?= $deliveryAddress->getAdd1() ?></p>

                                </div>
                                <div class="col-6 col-md-4">
                                    <p><strong>Prénom :</strong> <?= $deliveryAddress->getSurName() ?></p>
                                    <p><strong>Ville :</strong> <?= $deliveryAddress->getCity() ?></p>
                                    <p><strong>Addresse 2 :</strong><?= $deliveryAddress->getAdd2() ?></p>

                                </div>
                                <div class="col-6 col-md-4">
                                    <p><strong>Téléphone :</strong> <?= $deliveryAddress->getPhone() ?></p>
                                    <p><strong>Code postal :</strong> <?= $deliveryAddress->getPostCode() ?></p>
                                    <a class="btn btn-primary" href="/user/address/<?= $deliveryAddress->getId() ?>?goTo=/basket/buy">Modifier</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

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
    </br>
    <input type="submit" class="btn btn-primary" value="Payer" />
</form>

<script src="/assets/scripts/basket.js"></script>
<link rel="stylesheet" href="/assets/styles/basket.css">