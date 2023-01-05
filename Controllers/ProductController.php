<?php
require_once 'Controllers/Controller.php';
require_once 'Views/View.php';
require_once 'Models/Categorie.php';

class ProductController extends Controller
{
    function __construct()
    {
        parent::__construct('product');
        $this->get('getProductById', '/:id');
        $this->post('buyProduct', '/');
        $this->post('search', '/search');
    }

    public function getProductById($data)
    {
        $this->sendView('viewProduct', [
            'product' => Product::getProductById($data['params']['id']),
        ]);
    }

    public function buyProduct($data)
    {
        if (!isset($_POST['id'])) {
            $this->redirect("accueil"); //A tester
        }
        $product = Product::getProductById($_POST['id']);
        if (!isset($_POST['quantity'])) {
            $this->sendView('viewProduct', [
                'product' => $product,
            ]);
            return;
        }
        $_SESSION["basket"]->addProduct($product, $_POST['quantity']);
        $this->sendView('viewProduct', [
            'product' => $product,
            'quantityBought' => $_POST['quantity']
        ]);
    }

    public function search($data)
    {
        $input = json_decode(file_get_contents('php://input'));
        if (!isset($input->searchName)) {
            echo json_encode([]);
            return;
        };
        if (strlen($input->searchName) == 0) {
            echo json_encode([]);
            return;
        };
        echo json_encode(Product::getProductsByNameLike($input->searchName));
    }
}
