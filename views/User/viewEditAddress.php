<?php
if ($address == null) {
    echo "Address Inexistante";
    return;
}

?>
<div class="container ">
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <h1>Modification addresse
                <div>
            </h1>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <form class="row g-3 needs-validation" method="POST" action="/user/address/<?=$address->getId()?><?= isset($_GET["goTo"]) ? "?goTo=".$_GET["goTo"]:""?>">
                    <div class="col-md-6">
                        <label for="input-forename" class="form-label">Forename</label>
                        <input type="text" class="form-control" id="input-forename" placeholder="forename" name="forename" value="<?=$address->getForeName()?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="input-surename" class="form-label">Surename</label>
                        <input type="text" class="form-control" id="input-surename" placeholder="surename" name="surname" value="<?=$address->getSurName()?>" required>
                    </div>
                    <div class="col-md-12">
                        <label for="input-address1" class="form-label">Address 1</label>
                        <div class="input-group has-validation">
                            <input type="text" class="form-control" id="input-address1" aria-describedby="inputGroupPrepend" name="add1" value="<?=$address->getAdd1()?>" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="input-address2" class="form-label">Address 2</label>
                        <div class="input-group has-validation">
                            <input type="text" class="form-control" id="input-address2" aria-describedby="inputGroupPrepend" name="add2" value="<?=$address->getAdd2()?>" >                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="input-city" class="form-label">City</label>
                        <input type="text" class="form-control" id="input-city" name="city" value="<?=$address->getCity()?>" required>
                    </div>


                    <div class="col-md-6">
                        <label for="input-post-code" class="form-label">Post code</label>
                        <input type="text" class="form-control" id="input-post-code" name="postCode" value="<?=$address->getPostCode()?>" required>
                        <div class="invalid-feedback">
                            Please provide a valid zip.
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="input-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="input-email" name="email" value="<?=$address->getEmail()?>" required>
                        <div class="invalid-feedback">
                            Please provide a valid zip.
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-check-label" for="input-phone">
                            Phone
                        </label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">🇫🇷 (+33)</span>
                            <input class="form-control" type="tel"id="input-phone" pattern="0[1-9]\s?\d{2}\s?\d{2}\s?\d{2}\s?\d{2}" name="phone" value="<?=$address->getPhone()?>" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>