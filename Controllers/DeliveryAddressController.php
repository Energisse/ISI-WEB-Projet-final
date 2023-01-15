<?php
require_once 'Controllers/Controller.php';
require_once 'Views/View.php';
require_once 'Models/Categorie.php';
require_once 'Models/User.php';

class DeliveryAddressController extends Controller
{
    function __construct()
    {
        parent::__construct('address');
        //only if user is connected
        if (isset($_SESSION["User"])) {
            //form eddit or add
            $this->get('getFormAddress', '/:id');
            $this->get('getFormAddress', '/');
            //delete address
            $this->delete('deleteAddress', '/:id');
            //process data form add or edit
            $this->put('upadteAddress', '/:id');
            $this->post('createAddress', '/');
        } else {
            $this->get('redirection', '/(.*)');
        }
    }

    /**
     * send form
     * path = (get) /
     * path = (get) /:id
     * @param mixed $data
     * @return void
     */
    public function getFormAddress($data)
    {
        $deliveryAddresses = null;
        if (isset($data["params"]["id"])) {
            $deliveryAddresses = DeliveryAddress::getDeliveryAddressByIdAndUserId($data["params"]["id"], $_SESSION["User"]->getId());
        }

        $this->sendView("viewAddress", [
            "deliveryAddresses" => $deliveryAddresses,
            "error" => isset($data["prevRequestData"]["error"]) ? $data["prevRequestData"]["error"] : null,
            "formData" => isset($data["prevRequestData"]["formData"]) ? $data["prevRequestData"]["formData"] : [],
        ]);
    }
    public function deleteAddress($data)
    {
        DeliveryAddress::deleteDeliveryAddressByIdAndUserId($data["params"]["id"], $_SESSION["User"]->getId());
        $this->redirect("/user/addresses");
    }

    /**
     * Process data form
     * path = (put) /address:id
     * @param mixed $data
     * @return void
     */
    public function upadteAddress($data)
    {
        try {
            //Check if delivery address exist
            $address = DeliveryAddress::getDeliveryAddressByIdAndUserId($data["params"]["id"], $_SESSION["User"]->getId());
            if ($address == null) {
                //TODO: ERROR MESSAGE
                $this->redirect('/accueil');
                return;
            }

            DeliveryAddress::updateDeliveryAddressByIdAndUserId($_POST, $data["params"]["id"], $_SESSION["User"]->getId());

            if (isset($_GET["goTo"])) {
                $this->redirect($_GET["goTo"]);
                return;
            }
        } catch (FormException $formError) {
            $this->redirect("/address" . "/" . $data["params"]["id"], ["error" => $formError, "formData" => $_POST]);
            return;
        }
        $this->redirect("/user/addresses");
    }

    /**
     * Process data form
     * path = (post) /address
     * @param mixed $data
     * @return void
     */
    public function createAddress($data)
    {
        try {
            DeliveryAddress::createDeliveryAddress($_POST, $_SESSION["User"]->getId());
            if (isset($_GET["goTo"])) {
                $this->redirect($_GET["goTo"]);
                return;
            }
        } catch (FormException $formError) {
            $this->redirect("/address", ["error" => $formError, "formData" => $_POST]);
            return;
        }
        $this->redirect("/user/addresses");
    }

    /**
     * Redirect user if not connected
     * @param mixed $data
     * @return void
     */
    public function redirection($data)
    {
        $this->redirect("/user/login?goTo=/address" . $data["url"]);
    }
}
