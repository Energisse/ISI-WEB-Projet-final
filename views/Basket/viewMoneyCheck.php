<?php
require_once 'Models/DeliveryAddress.php';
require_once 'views/Components/OrderSummary.php';
?>

<div class="d-flex flex-row">
    <form action="/basket/pay" method="post" class="col d-flex flex-row-column justify-content-center">
        <div class="col-md-8">

            <div class="col-md-12">
                Vous devrais envoyer le cheque a ....
            </div>
            <div class="col-md-12">
                <input type="submit" class="btn btn-primary" value="payer">
                <input type="hidden" class="btn btn-primary" value="moneyCheck" name="payment_type">

            </div>
        </div>
    </form>
    <?= OrderSummary($order, $deliveryAddress) ?>
</div>