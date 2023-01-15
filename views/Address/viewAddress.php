<div class="container ">
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <h1>
                <?= $deliveryAddresses ? "Modification addresse" : "Création d'une addresse" ?>
            </h1>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <form class="row g-3 needs-validation" method="POST" action="/address<?= $deliveryAddresses ? "/" . $deliveryAddresses->getId() : "" ?><?= isset($_GET["goTo"]) ? "?goTo=" . $_GET["goTo"] : "" ?>">
                    <?= $deliveryAddresses ? '<input type="hidden" name="_method" value="put" />' : '' ?>
                    <div class="col-md-6">
                        <label for="input-forename" class="form-label">Forename</label>
                        <input type="text" class="form-control <?= $error && $error->getAttributName() ==  "forename" ? "is-invalid" : ""  ?>" id="input-forename" placeholder="forename" name="forename" value="<?= isset($formData["forename"]) ? $formData["forename"] : ($deliveryAddresses ?  $deliveryAddresses->getForeName() : "") ?>" required>
                        <div class="invalid-feedback">
                            <?= $error ? $error->getMessage() : "" ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="input-surename" class="form-label">Surename</label>
                        <input type="text" class="form-control <?= $error && $error->getAttributName() ==  "surname" ? "is-invalid" : ""  ?>" id="input-surename" placeholder="surename" name="surname" value="<?= isset($formData["surname"]) ? $formData["surname"] : ($deliveryAddresses ? $deliveryAddresses->getSurName() : "") ?>" required>
                        <div class="invalid-feedback">
                            <?= $error ? $error->getMessage() : "" ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="input-address1" class="form-label">Address 1</label>
                        <div class="input-group has-validation">
                            <input type="text" class="form-control <?= $error && $error->getAttributName() ==  "add1" ? "is-invalid" : ""  ?>" id="input-address1" aria-describedby="inputGroupPrepend" name="add1" value="<?= isset($formData["add1"]) ? $formData["add1"] : ($deliveryAddresses ? $deliveryAddresses->getAdd1() : "") ?>" required>
                            <div class="invalid-feedback">
                                <?= $error ? $error->getMessage() : "" ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="input-address2" class="form-label">Address 2</label>
                        <div class="input-group has-validation">
                            <input type="text" class="form-control <?= $error && $error->getAttributName() ==  "add2" ? "is-invalid" : ""  ?>" id="input-address2" aria-describedby="inputGroupPrepend" name="add2" value="<?= isset($formData["add2"]) ? $formData["add2"] : ($deliveryAddresses ? $deliveryAddresses->getAdd2() : "") ?>">
                            <div class="invalid-feedback">
                                <?= $error ? $error->getMessage() : "" ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="input-city" class="form-label">City</label>
                        <input type="text" class="form-control <?= $error && $error->getAttributName() ==  "city" ? "is-invalid" : ""  ?>" id="input-city" name="city" value="<?= isset($formData["city"]) ? $formData["city"] : ($deliveryAddresses ?  $deliveryAddresses->getCity() : "") ?>" required>
                        <div class="invalid-feedback">
                            <?= $error ? $error->getMessage() : "" ?>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <label for="input-post-code" class="form-label">Post code</label>
                        <input type="text" class="form-control <?= $error && $error->getAttributName() ==  "postcode" ? "is-invalid" : ""  ?>" id="input-post-code" name="postcode" value="<?= isset($formData["postcode"]) ? $formData["postcode"] : ($deliveryAddresses ? $deliveryAddresses->getPostCode() : "") ?>" required>
                        <div class="invalid-feedback">
                            <?= $error ? $error->getMessage() : "" ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="input-email" class="form-label">Email</label>
                        <input type="email" class="form-control <?= $error && $error->getAttributName() ==  "email" ? "is-invalid" : ""  ?>" id="input-email" name="email" value="<?= isset($formData["email"]) ? $formData["email"] : ($deliveryAddresses ? $deliveryAddresses->getEmail() : "") ?>" required>
                        <div class="invalid-feedback">
                            <?= $error ? $error->getMessage() : "" ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-check-label" for="input-phone">
                            Phone
                        </label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">🇫🇷 (+33)</span>
                            <input class="form-control <?= $error && $error->getAttributName() ==  "phone" ? "is-invalid" : ""  ?>" type="tel" id="input-phone" pattern="0?[1-9]\s?\d{2}\s?\d{2}\s?\d{2}\s?\d{2}" name="phone" value="<?= isset($formData["phone"]) ? $formData["phone"] : ($deliveryAddresses ? $deliveryAddresses->getPhone() : "") ?>" required>
                            <div class="invalid-feedback">
                                <?= $error ? $error->getMessage() : "" ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit"> <?= $deliveryAddresses ? "Modifier" : "Créer" ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>