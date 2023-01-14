<?php
function OrderSummary(Order $order)
{
?>
    <div>
        <ul class="list-group">
            <li class="list-group-item">Produits</li>
            <li class="list-group-item">
                <div class="d-flex flex-column">
                    <?php
                    foreach ($order->getOrderItems() as $item) {
                    ?>
                        <div class="d-flex flex-row align-items-center">
                            <div class="col" class="p-1">
                                <img src="/assets/productimages/<?= $item->getProduct()->getImage() ?>" width="32" height="32" />
                                <?= $item->getProduct()->getName() ?>
                            </div>
                            <div class="p-1">
                                <?= $item->getQuantity() ?> x <?= $item->getProduct()->getPrice() ?> = <?= $item->getProduct()->getPrice() * $item->getQuantity() ?> €
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </li>
            <li class="list-group-item">
                <div class="d-flex flex-row align-items-center">
                    <div class="col" class="p-1">
                        Prix HT
                    </div>
                    <div class="p-1">
                        <?= $order->getPrice() * 0.8; ?> €
                    </div>
                </div>
                <div class="d-flex flex-row align-items-center">
                    <div class="col" class="p-1">
                        TVA
                    </div>
                    <div class="p-1">
                        <?= $order->getPrice() * 0.2; ?> €
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="d-flex flex-row align-items-center">
                    <div class="col" class="p-1">
                        Prix Total
                    </div>
                    <div class="p-1">
                        <?= $order->getPrice() ?> €
                    </div>
                </div>
            </li>
        </ul>
    </div>
<?php
}
