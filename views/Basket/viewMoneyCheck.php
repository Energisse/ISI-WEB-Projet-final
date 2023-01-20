<?php
require_once 'Models/DeliveryAddress.php';
require_once 'views/Components/OrderSummary.php';
?>

<div class="d-flex flex-row">
    <form action="/basket/pay" method="post" class="col d-flex flex-row-column justify-content-center">
        <div class="col-md-8">

            <div class="col-md-12">
                Envoyer le chèque à cette adresse : 69100 Villeurbanne<br>
                Ordre du chèque : Direction comptable IsiWeb4Shop<br> 
                Si toutefois vous rencontrez un problème lors de l'envoie du chèque, veuillez contacter:<br>
                Thomas Aucarré, agent comptable IsiWeb4Shop<br>
                <i class="fa-solid fa-phone"></i>Tel: 08 72 15 95 36<br>
                <i class="fa-solid fa-envelope"></i>Mail professionnel: thomasau2@gmail.com<br>

            </div>
            <div class="col-md-12">
                <input type="submit" class="btn btn-primary" value="Payer">
                <input type="hidden" class="btn btn-primary" value="moneyCheck" name="payment_type">

            </div>
        </div>
    </form>
    <?= OrderSummary($order, $deliveryAddress) ?>
</div>