<?php
require_once 'Controllers/Controller.php';
require_once 'Views/View.php';
require_once 'Models/Categorie.php';

class ControllerCategorie extends Controller
{
    function __construct()
    {
        parent::__construct('categorie');
        $this->get('index', '/');
        $this->get('getCategorieById', '/:id');
    }

    public function index($data)
    {
        return (new view('Categorie/viewAccueil'))->generer([
            'categories' => Categorie::getALlCategories(),
        ]);
    }

    public function getCategorieById($data)
    {
        return (new view('Categorie/viewCategorie'))->generer([
            'categorie' => Categorie::getCategorieById($data['params']['id']),
        ]);
    }

    protected function notFound()
    {
        echo "Wesh t'abuse frerot";
    }
}
