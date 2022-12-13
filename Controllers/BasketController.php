<?php
require_once 'Controllers/Controller.php';
require_once 'Views/View.php';
require_once 'Models/Categorie.php';

class BasketController extends Controller
{
    function __construct()
    {
        parent::__construct('basket');
        $this->get('index', '/');
        $this->get('clear', '/clear');
    }

    public function index($data)
    {
        $this->sendView('viewBasket', ["basket" => $_SESSION["basket"]]);
    }

    public function clear($data)
    {

        $_SESSION["basket"]->clear();
        $this->sendView('viewBasket', ["basket" => $_SESSION["basket"]]);
    }
}