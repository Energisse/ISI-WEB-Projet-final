<?php
// require_once 'Controleur/ControleurAccueil.php';
// require_once 'Controleur/ControleurBillet.php';
// require_once 'Vue/Vue.php';
require_once 'Controllers/ControllerCategorie.php';

class Routeur
{
    private $controllers = [];

    public function __construct()
    {
        $this->addController(new ControllerCategorie());
    }

    private function addController($controller)
    {
        $this->controllers[$controller->getName()] = $controller;
    }
    // Traite une requête entrante
    public function routerRequete()
    {
        try {
            if (isset($this->controllers[$_GET['controller']])) {
                $this->controllers[$_GET['controller']]->call();
            }
        } catch (Exception $e) {
            $this->erreur($e->getMessage());
        }
    }
    // Affiche une erreur
    private function erreur($msgErreur)
    {
        $vue = new Vue('Erreur');
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
