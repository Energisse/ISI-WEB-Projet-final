<?php
require_once 'Controllers/Controller.php';
require_once 'Views/View.php';
require_once 'Models/Categorie.php';

class CategorieController extends Controller
{
    function __construct()
    {
        parent::__construct('categorie');
        $this->get('index', '/');
        $this->get('getCategorieById', '/:id');
    }

    public function index($data)
    {
        $this->sendView('viewAccueil', [
            'categories' => Categorie::getALlCategories(),
        ]);
    }

    public function getCategorieById($data)
    {
        $this->sendView('viewCategorie', [
            'categorie' => Categorie::getCategorieById($data['params']['id']),
        ]);
    }
}