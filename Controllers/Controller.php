<?php
require_once 'utils/path-to-regexp-php/src/PathToRegexp.php';

abstract class Controller
{
    private $routes = ['GET' => [], 'POST' => []];
    //definie par la class fille
    private $name;

    function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    protected function sendView($view, $donnees = [])
    {
        (new view($this->name . "/" . $view))->generer($donnees);
    }

    protected function redirect(string $path)
    {
        header('Location: /' . $path);
    }
    protected function get($action, $path)
    {
        $this->addRoute('GET', $action, $path);
    }

    protected function post($action, $path)
    {
        $this->addRoute('POST', $action, $path);
    }

    private function addRoute($method, $action, $path)
    {
        $key = [];
        array_push($this->routes[$method], [
            'path' => PathToRegexp::convert($path, $key),
            'action' => $action,
            'key' => $key,
        ]);
    }

    public function call(Request $request): mixed
    {
        //On verifie toutes les routes du controller
        foreach ($this->routes[$request->getMethod()] as $route) {
            $matches = PathToRegexp::match ($route['path'], $request->getAction());
            //Si aucun match alors on passe a la suite
            if ($matches == null) {
                continue;
            }

            //Création d'un tableau contenant les données a passer a l'action
            $data = ['url' => $request->getAction()];
            //Recréation des parametre par rapport au clé = ([0]=>foo,[1]=>bar) et aux matchs = ([0]=>xxx/xxx,[1]=>valeur1,[2]=>valeur2)
            for ($i = 1; $i < count($matches); $i++) {
                $data['params'] = [
                    $route['key'][$i - 1]['name'] => $matches[$i],
                ];
            }

            //On appel l'action avec les données
            $result = $this->{$route['action']}($data);
            if (!$result)
                return true;
            return $result;
        }
        return false;
    }
}