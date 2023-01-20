<div class="container-fluid">
    <h1>Panier</h1>
    <div class="table-responsive-xxl">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th scope="col">Produit</th>
                    <th scope="col">Quantité</th>
                    <th scope="col">Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($order->getOrderItems() as $items) {
                ?>
                    <tr>
                        <td>
                            <img src="/assets/public/productimages/<?= $items->getProduct()->getImage() ?>" alt="<?= $items->getProduct()->getName()  ?>" width="64" height="64">
                            <?= $items->getProduct()->getName() ?>

                        </td>
                        <td><?= $items->getQuantity() ?></td>
                        <td>
                            <form action="/basket/<?= $items->getProduct()->getId() ?>" method="post">
                                <input type="hidden" name="_method" value="delete" />
                                <input type="submit" class="btn btn-danger" value="Supprimer" />
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <a href="/basket/buy" class="btn btn-primary">Payer</a>
        <a href="/basket/clear" class="btn btn-danger">Vider</a>
    </div>
</div>