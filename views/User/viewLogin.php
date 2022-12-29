<?php
if (!isset($error)) {
    $error = false;
}
?>

<div class="container-sm">
    <div class="row  justify-content-sm-center">
        <div class="col-sm-6">
            <form action="/user/login<?= isset($goTo) ? "?goTo=".$goTo:""?>" method="post"
                class="d-flex flex-column justify-content-sm-center flex-wrap gap-3 border rounded m-5 p-5">
                <h1>Connexion</h1>
                <div class="form-group">
                    <label for="username">Nom utilisateur</label>
                    <input name="username" type="text" class="form-control <?= $error ? "is-invalid" : "" ?>"
                        id="username" placeholder="Nom utilisateur" value="<?= isset($username) ? $username : "" ?>">
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input name="password" type="password" class="form-control  <?= $error ? "is-invalid" : "" ?>"
                        id="password" placeholder="Mot de passe">
                </div>
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>
            <?php
            if ($error) {
            ?>
            <div class="alert alert-danger" role=" ">
                Connexion incorrecte !
            </div>
        </div>
    </div>
</div>
<?php
            }