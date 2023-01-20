<?php
// require_once 'Controleur/ControleurAccueil.php';
// require_once 'Controleur/ControleurBillet.php';
// require_once 'Vue/Vue.php';
require_once 'Controllers/CategorieController.php';
require_once 'Controllers/UserController.php';
require_once 'Controllers/AccueilController.php';
require_once 'Controllers/ProductController.php';
require_once 'Controllers/BasketController.php';
require_once 'Controllers/AdminController.php';
require_once 'Controllers/DeliveryAddressController.php';

class Routeur
{
    private $controllers = [];

    public function __construct()
    {
        $this->addController(new CategorieController());
        $this->addController(new UserController());
        $this->addController(new AccueilController());
        $this->addController(new ProductController());
        $this->addController(new BasketController());
        $this->addController(new AdminController());
        $this->addController(new DeliveryAddressController());
    }

    private function addController($controller)
    {
        $this->controllers[$controller->getName()] = $controller;
    }
    // Traite une requête entrante
    public function routerRequete(Request $request)
    {
        try {
            if (isset($this->controllers[$request->getController()])) {
                $result = $this->controllers[$request->getController()]->call($request);

                if ($result) //On verifie que la requete a bien été traité
                    return;
            }
            //La requete n'a pas été traité par le controller
            //Retourne 404
            (new View("404"))->generer();
        } catch (Exception $e) {
            include('views/500.php');
            //$this->erreur($e->getMessage());
        }
    }
    // Affiche une erreur
    private function erreur($msgErreur)
    {
        $vue = new View('Erreur');
        $vue->generer(['msgErreur' => $msgErreur]);
    }

    // Recherche un paramètre dans un tableau
    private function getParametre($tableau, $nom)
    {
        if (isset($tableau[$nom])) {
            return $tableau[$nom];
        } else {
            throw new Exception("Paramètre '$nom' absent");
        }
    }
}
