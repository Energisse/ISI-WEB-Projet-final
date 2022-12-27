<?php
require_once 'Models/DeliveryAddress.php';
?>
<form method="post" action="">
<h1>Addresse de livraison</h1>
    <?php
    foreach($deliveryAddresses as $deliveryAddress){
    ?>
        <div class="container container-address">
        <label class="form-check-label">
        <input class="form-check-input radio-address" type="radio" name="address" value="<?=$deliveryAddress->getId()?>">
        <!-- <i class="fa-solid fa-location-dot"></i> -->
        <?= $deliveryAddress->getForeName()?>
        <?= $deliveryAddress->getSurName()?>,
        <?= $deliveryAddress->getAdd1()?>,
        <?= $deliveryAddress->getAdd2()?>,
        <?= $deliveryAddress->getCity()?>,
        <?= $deliveryAddress->getPostCode()?>,
        <?= $deliveryAddress->getPhone() ?>
        </label>
        <a class="btn btn-link">Modifier</a>
        </div>
    <?php
    }
    ?>
    
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
    <input type="submit" class="btn btn-primary" value="Payer"/>
</form>

<script src="/assets/scripts/basket.js"></script>
<link rel="stylesheet" href="/assets/styles/basket.css">
