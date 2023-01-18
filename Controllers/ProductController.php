<?php
require_once 'Controllers/Controller.php';
require_once 'Views/View.php';
require_once 'Models/Categorie.php';

class ProductController extends Controller
{
    function __construct()
    {
        parent::__construct('product');
        $this->post('review', '/review/:id');
        $this->post('search', '/search');
        $this->get('getProductById', '/:id');
        $this->post('buyProduct', '/:id');
    }

    public function getProductById($data)
    {
        $product = Product::getProductById($data['params']['id']);
        $reviews = $product->getReviews();
        $userReview = null;
        //Split connected user reviews and other user reviews
        if (isset($_SESSION["User"])) {
            for ($i = 0; $i < count($reviews); $i++) {
                if ($reviews[$i]->getUserId() == $_SESSION["User"]->getId()) {
                    $userReview = $reviews[$i];
                    array_splice($reviews, $i, 1);
                    break; //Only one review by user so when foud it's finish   
                }
            }
        }
        $this->sendView('viewProduct', [
            'product' => $product,
            'userReview' => $userReview,
            'reviews' => $reviews,
            'quantityBought' => isset($data["prevRequestData"]["quantityBought"]) ? $data["prevRequestData"]["quantityBought"] : 0,
            'reviewEdited' => isset($data["prevRequestData"]["reviewEdited"]) ? $data["prevRequestData"]["reviewEdited"] : false,
            'error' => isset($data["error"]) ? $data["error"] : null,
        ]);
    }

    public function buyProduct($data)
    {
        if (!isset($data['params']['id'])) {
            return $this->redirect("accueil"); //A tester
        }
        if (!isset($_POST['quantity'])) {
            $this->redirect("/product" . "/" . $data['params']['id']);
        }

        $product = Product::getProductById($data['params']['id']);

        if (!$product) {
            return $this->redirect("accueil");
        }

        if ($product->getQuantityRemaining() <  $_POST['quantity']) {
            echo "non";
            die();
        }

        $order =  Order::getOrderBySessionId(session_id());
        $order->setStatus(OrderStatusCode::$InPurchase)->addItem($product, $_POST['quantity']);



        //send product view
        $this->redirect("/product" . "/" . $data['params']['id'], ["quantityBought" => $_POST['quantity']]);
    }

    public function review($data)
    {
        $params = [];
        try {
            Review::createOrEditReviewByProductIdANdUserId($data["params"]["id"], $_SESSION["User"]->getId(), $_POST);
            $params = ["reviewEdited" => true];
        } catch (FormException $error) {
            $params = ["error" => $error];
        }

        $this->redirect("/product" . "/" . $data['params']['id'], $params);
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
