<?php
require_once 'Controllers/Controller.php';
require_once 'Views/View.php';
require_once 'Models/Categorie.php';

class AccueilController extends Controller
{
    function __construct()
    {
        parent::__construct('');
        $this->get('index', '/');
    }

    public function index($data)
    {
        $this->sendView('viewAccueil');
    }
}