<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';

class OrderItem extends Modele
{
    private $orderId;
    private $date;
    private $status;

    function __construct($data)
    {
        $this->id = $data['id'];
        $this->orderId = $data['order_id'];
        $this->productId = $data['product_id'];
        $this->quantity = $data['quantity'];
    }
}