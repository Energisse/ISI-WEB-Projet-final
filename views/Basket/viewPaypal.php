<?php
require_once 'Models/DeliveryAddress.php';
require_once 'views/Components/OrderSummary.php';
?>

<div class="d-flex flex-row">
    <form action="/basket/pay" method="post" class="col d-flex flex-row-column justify-content-center">
        <div class="col-md-8">
            <div class="col-md-12">
                <label for="input-paypal-mail" class="form-label">Mail</label>
                <input type="mail" class="form-control " id="input-paypal-mail" name="paypal_mail">
            </div>
            <div class="col-md-12">
                <label for="input-paypal-password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control " id="input-paypal-password" name="paypal_password">
            </div>
            <input type="submit" class="btn btn-primary" value="payer">
            <input type="hidden" class="btn btn-primary" value="paypal" name="payment_type">
        </div>
    </form>
    <?= OrderSummary($order, $deliveryAddress) ?>
</div>