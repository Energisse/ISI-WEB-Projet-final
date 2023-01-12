<div class="container-fluid">
    <h1>Liste de vos addresses</h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Téléphone</th>
                <th scope="col">Email</th>
                <th scope="col">Addresse</th>
                <th scope="col">Addresse complemtaire</th>
                <th scope="col">Vile</th>
                <th scope="col">Code postal</th>
                <th scope="col">Modifier</th>
                <th scope="col">Supprimer
                <th>

            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($deliveryAddresses as $deliveryAddress) {
            ?>
                <tr>
                    <td><?= $deliveryAddress->getSurName() ?>,</td>
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
                        <form action="/address/<?= $deliveryAddress->getId() ?>" method="post">
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
    <a href="/address" class="btn btn-link">Ajouter une addresse</a>
</div>