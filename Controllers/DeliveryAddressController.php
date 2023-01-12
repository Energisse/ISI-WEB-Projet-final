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
        if (isset($_SESSION["User"])) {
            $this->get('getFormAddress', '/:id');
            $this->get('getFormAddress', '/');
            $this->delete('deleteAddress', '/:id');
            $this->put('onCreateOrUpadteAddress', '/:id');
            $this->post('onCreateOrUpadteAddress', '/');
        } else {
            $this->get('redirection', '/(.*)');
        }
    }

    public function redirection()
    {
        $this->redirect("/user/login");
    }
    public function getFormAddress($data)
    {
        $deliveryAddresses = null;
        if (isset($data["params"]["id"])) {
            $deliveryAddresses = DeliveryAddress::getDeliveryAddressByIdAndUserId($data["params"]["id"], $_SESSION["User"]->getId());
        }
        $this->sendView("viewAddress", ["deliveryAddresses" => $deliveryAddresses, "error" => isset($data["error"]) ? $data["error"] : null]);
    }
    public function deleteAddress($data)
    {
        DeliveryAddress::deleteDeliveryAddressByIdAndUserId($data["params"]["id"], $_SESSION["User"]->getId());
        $this->redirect("/user/addresses");
    }

    public function onCreateOrUpadteAddress($data)
    {
        try {
            if (isset($data["params"]["id"])) {
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
            } else {
                DeliveryAddress::createDeliveryAddress($_POST, $_SESSION["User"]->getId());
            }
            $this->redirect("/user/addresses");
        } catch (FormException $error) {
            $data["error"] = $error;
            $this->getFormAddress($data);
        }
    }
}
