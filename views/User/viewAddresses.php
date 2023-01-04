<div class="container">
        <div class="accordion" id="accordionAddresses">

            <?php
            foreach ($deliveryAddresses as $deliveryAddress) {
            ?>
                <div class="row">
                    <div data-bs-toggle="collapse" data-bs-target="#collapse<?= $deliveryAddress->getId() ?>" aria-expanded="true" aria-controls="collapseOne">
                            <?= $deliveryAddress->getForeName() ?>
                            <?= $deliveryAddress->getSurName() ?>,
                            <?= $deliveryAddress->getCity() ?>,
                            <?= $deliveryAddress->getPostCode() ?>,
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
        <a href="/user/address" class="btn btn-link">Ajouter une addresse</a>
    </div>