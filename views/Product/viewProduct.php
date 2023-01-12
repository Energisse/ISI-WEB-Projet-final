<?php
require_once("Views/Components/Review.php");
?>
<script src="/assets/scripts/product.js" defer></script>

<div class="d-flex d-flex flex-column align-items-center">
    <form method="post" class="d-flex">
        <div class="p-5 flex-grow-1  text-end">
            <img src="/assets/productimages/<?= $product->getImage() ?>" alt="<?= $product->getName() ?>" width="250" height="250">
        </div>
        <div class="p-5 flex-grow-1  d-flex flex-column">
            <div class="p-2 flex-fill ">
                <h1>
                    <?= $product->getName() ?>
                </h1>
            </div>
            <div class="p-2 flex-fill ">
                <?= $product->getDescription() ?>
            </div>
            <div class="p-2 flex-fill ">
                <button type="submit" class="btn btn-primary">Acheter <?= $product->getPrice() ?>€</button>
                <input type="number" min="1" max="<?= $product->getQuantityRemaining() ?>" name="quantity" value="1" />
            </div>
        </div>
    </form>
    <div class="col-md-8 ">
        <?php
        if ($quantityBought) {
        ?>
            <div class=" flex-fill alert alert-success" role=" ">
                Produit ajouté <?= $quantityBought > 1 ? $quantityBought . " fois" : "" ?> au panier !
            </div>
        <?php
        }
        ?>
    </div>
    <div class="col-md-8 ">
        <?php
        if ($userReview) {
        ?>
            <div id="user-review" style='<?= $error ? "display:none;" : "" ?>'>
                <?= Review($userReview); ?>
                <button class="btn btn-primary toggleEditReview">Modifier</button>

            </div>
            <?php
            if ($reviewEdited) {
            ?>
                <div class=" flex-fill alert alert-success" role=" ">
                    Commentaire modifé !
                </div>
            <?php
            }
        }
        if (isset($_SESSION["User"])) {
            ?>

            <div id="form-review" style='<?= $userReview && !$error ? "display:none;" : "" ?>'>
                <form action='/product/review/<?= $product->getId() ?>' method="post">
                    <div class="rating">
                        <?php
                        $star = $userReview ? $userReview->getStars() : 1;
                        ?>
                        <input type="radio" name="stars" id="star5" <?= $star == 5 ? "checked" : "" ?> value="5" /><label for="star5"></label>
                        <input type="radio" name="stars" id="star4" <?= $star == 4 ? "checked" : "" ?> value="4" /><label for="star4"></label>
                        <input type="radio" name="stars" id="star3" <?= $star == 3 ? "checked" : "" ?> value="3" /><label for="star3"></label>
                        <input type="radio" name="stars" id="star2" <?= $star == 2 ? "checked" : "" ?> value="2" /><label for="star2"></label>
                        <input type="radio" name="stars" id="star1" <?= $star == 1 ? "checked" : "" ?> value="1" /><label for="star1"></label>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Titre</label>
                        <input type="text" class="form-control <?= $error && $error->getAttributName() ==  "title" ? "is-invalid" : ""  ?>" name="title" placeholder="titre" value="<?= isset($_POST["title"]) ? $_POST["title"] : ($userReview ? $userReview->getTitle() : "") ?>" required>
                        <div class="invalid-feedback">
                            <?= $error ? $error->getMessage() : "" ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea class="form-control <?= $error && $error->getAttributName() ==  "description" ? "is-invalid" : ""  ?>" name="description" placeholder="description" required><?= isset($_POST["description"]) ? $_POST["description"] : ($userReview ?  $userReview->getDescription() : "") ?></textarea>
                        <div class="invalid-feedback">
                            <?= $error ? $error->getMessage() : "" ?>
                        </div>
                    </div>
                    <input type="submit" value="<?= $userReview ? "Modifier" : "Poster" ?>" class="btn btn-primary" />
                    <button type="button" class="btn btn-danger toggleEditReview">Annuler</button>
                </form>

            </div>

        <?php
        } else {
        ?>
            Connectez vous pour poster un commentaire !
        <?php
        }
        foreach ($reviews as $review) {
            Review($review);
        }
        ?>
    </div>
</div>

<link rel="stylesheet" href="/assets/styles/product.css">