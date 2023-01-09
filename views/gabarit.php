<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/9b3d8c993e.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="/assets/scripts/gabarit.js" defer></script>
    <link href="https://fonts.cdnfonts.com/css/amazon-ember" rel="stylesheet">
    <link rel="stylesheet" href="/assets/styles/index.css">
    <title>
        <?= $titre ?>
    </title>
</head>

<body>
    <header>
        <img id="logo" src="/assets/images/Web4ShopHeader.png" alt="image" class="img-responsive d-block mx-auto" />
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Accueil</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                        <?php
                        if (isset($_SESSION["User"]) && $_SESSION["User"]->isAdmin()) {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/">
                                    Admin
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                        <li class="nav-item  d-flex justify-content-center align-items-center">
                            <a href="/basket">
                                <div class="basket-container">
                                    <div class="basket-quantity">
                                        <?=
                                        $_SESSION["basket"]->getQuantity() > 99 ? "99+" : $_SESSION["basket"]->getQuantity()
                                        ?>
                                    </div>
                                    <i class=" fa-solid fa-basket-shopping "></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php
                                if (isset($_SESSION["User"])) {
                                ?>
                                    <li>
                                        <a class="dropdown-item" href="/user/addresses">Mes addresses</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/user/orders">Mes commandes</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/user/logout">Deconnexion</a>
                                    </li>

                                <?php
                                } else {
                                ?>

                                    <li>
                                        <a class="dropdown-item" href="/user/User">Connexion</a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                    <div class="position-relative" tabindex="-1" id="container-list-and-search">
                        <input class="form-control me-2" type="search" id="search" placeholder="Search" aria-label="Search">
                        <div id="container-list-search">
                            <div id="list-search" class="d-flex flex-column ">

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </nav>
    </header>

    <div id="contenu">
        <?= $contenu ?>
    </div>
    <footer>
        <p class="font-weight-light">Pour toute demande d'informations:</p>
        <ul>
            <li>Contact service commercial: Mr Thomas</li>
            <li>Contact service communication: Mr Thomas</li>
            <li>Contact service juridique: Mr Thomas</li>
        </ul>
        Retrouver nous aussi sur : <i class="fab fa-facebook-f fa-2x" style="color: #3b5998;"></i>
        <i class="fab fa-twitter fa-2x" style="color: #55acee;"></i>
        <small>© copyright 2023</small>
    </footer>
</body>


</html>