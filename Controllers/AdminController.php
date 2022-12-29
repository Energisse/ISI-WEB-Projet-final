<?php
require_once 'Controllers/Controller.php';
require_once 'Views/View.php';
require_once 'Models/Categorie.php';
require_once 'Models/DeliveryAddress.php';

class AdminController extends Controller
{
    function __construct()
    {
        parent::__construct('admin');
        //est connecté
        if(isset($_SESSION["login"])){
            //est admin
            if($_SESSION["login"]->isAdmin()){
                $this->get('index', '/');
            }
            //rien car non admin
        }
        //demande de connection
        else{
            $this->get('redirection', '/');

        }
    }

    public function index($data)
    {
        echo "YO l'admin";
    }

    public function redirection(){
        $this->redirect("/user/login");
    }

}