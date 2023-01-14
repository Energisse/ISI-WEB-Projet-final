<?php
require_once 'Models/DeliveryAddress.php';
require_once 'views/Components/OrderSummary.php';
?>

<div class="d-flex flex-row">
    <form action="/basket/creditCard" method="post" class="col d-flex flex-row-column justify-content-center">
        <div class="col-md-8">
            <div class="col-md-12">
                <label for="input-card-number" class="form-label">N° de carte:</label>
                <input type="text" class="form-control " id="input-card-number" placeholder="xxxx xxxx xxxx xxxx" name="card_number">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="input-card-name" class="form-label">Nom sur la carte</label>
                    <input type="text" class="form-control " id="input-card-name" placeholder="Thomas Thomas" name="card_name">
                </div>
                <div class="col-md-3">
                    <label for="input-card-cvc" class="form-label">Date d'expiration</label>
                    <input type="text" class="form-control " id="input-card-cvc" placeholder="xx/xx" name="card_cvc">
                </div>
                <div class="col-md-3">
                    <label for="input-card-cvc" class="form-label">CVC</label>
                    <input type="number" class="form-control " id="input-card-cvc" placeholder="xxx" name="card_cvc">
                </div>
            </div>
            <input type="submit" class="btn btn-primary" value="payer">

        </div>

    </form>
    <?= OrderSummary($order) ?>
</div>