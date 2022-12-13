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
        $this->post('buyProduct', '/:id');
    }

    public function getProductById($data)
    {
        $this->sendView('viewProduct', [
            'product' => Product::getProductById($data['params']['id']),
        ]);
    }

    public function buyProduct($data)
    {
        $product = Product::getProductById($data['params']['id']);
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
}