<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/styles/index.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/9b3d8c993e.js" crossorigin="anonymous"></script>
    <title>
        <?= $titre ?>
    </title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><i class="fa-solid fa-house"></i>Accueil</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Categorie
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php foreach ($categories as $categorie) { ?>
                            <li><a class="dropdown-item" href="/categorie/<?= $categorie->getId() ?>/">
                                    <?= $categorie->getName() ?>
                                </a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item  d-flex justify-content-center align-items-center">
                        <a href="/basket">
                            <div class="basket-container">
                                <div class="basket-quantity">
                                    <?= 
                                    $_SESSION["basket"]->getQuantity() > 99 ? "99+" : $_SESSION["basket"]->getQuantity()
                                        ?>
                                </div>
                                <i class=" fa-solid fa-basket-shopping "></i>Shop
                            </div>
                        </a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            <div>
            <?php
                        if (isset($_SESSION["login"])) {
                            echo '<a class="nav-link" href="/user/logout">Deconnexion</a>';
                        } else {
                            echo '<a class="nav-link" href="/user/login">Connexion</a>';
                        }
                        ?>
        </div>
            </div>
        </div>
    </nav>
    <?= $contenu ?>

</body>

</html>