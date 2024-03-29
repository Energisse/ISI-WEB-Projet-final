<div class="container">
    <div class="row  justify-content-sm-center">
        <div class="col-sm-10 col-xxl-6">
            <form action="/user/signin<?= isset($goTo) ? "?goTo=" . $goTo : "" ?>" method="post" class="d-flex flex-column justify-content-sm-center flex-wrap gap-3 border rounded m-5 p-5">
                <h1>Création d'un compte utilisateur</h1>
                <div class="form-group">
                    <label for="username">Identifiant</label>
                    <input name="username" type="text" class="form-control <?= $userNameUsed ? "is-invalid" : "" ?>" id="username" placeholder="Nom utilisateur" value="<?= isset($username) ? $username : "" ?>">
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input name="password" type="password" class="form-control  <?= $userNameUsed ? "is-invalid" : "" ?>" id="password" placeholder="Mot de passe">
                </div>
                <button type="submit" class="btn btn-primary">S'inscrire</button>
            </form>
            <?php
            if ($userNameUsed) {
            ?>
                <div class="alert alert-danger">
                    Nom utilisateur déjà utilisé
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>