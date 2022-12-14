<?php
require_once 'Controllers/Controller.php';
require_once 'Views/View.php';
require_once 'Models/Categorie.php';
require_once 'Models/Login.php';

class UserController extends Controller
{
    function __construct()
    {
        parent::__construct('user');
        $this->get('loginForm', '/login');
        $this->post('login', '/login');
        $this->get('logout', '/logout');
    }

    public function loginForm($data)
    {
        if (isset($_SESSION["login"])) {
            $this->redirect("/categorie");
            return;
        }
        $this->sendView("viewLogin",["goTo"=>isset($_GET["goTo"]) ? $_GET["goTo"] : null]);
    }

    public function logout($data)
    {
        session_destroy();
        $this->redirect("/user/login");
    }

    public function login($data)
    {
        if (isset($_SESSION["login"])) {
            $this->redirect("/categorie");
            return;
        }

        if (isset($_POST["username"]) && $_POST["password"]) {
            $login = Login::getLoginByUsernameAndPassword($_POST["username"], $_POST["password"]);
            if ($login != null) {
                $_SESSION["login"] = $login;
                //Si la connexion a été demandé par une autre page on y repars 
                if(isset($_GET["goTo"]))  $this->redirect($_GET["goTo"]);
                else $this->redirect("/categorie");
                return;

            }
        }
        $this->sendView("viewLogin", ["error" => true, "username" => $_POST["username"],"goTo"=>isset($_GET["goTo"]) ? $_GET["goTo"] : null]);

    }

}