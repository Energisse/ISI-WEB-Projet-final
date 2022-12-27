<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';

class OrderItem extends Modele
{
    private int $status;
    private int $orderId;
    private int $date;

    function __construct($data)
    {
        $this->status = $data['status'];
        $this->date = $data['date'];
        $this->orderId = $data['order_id'];
    }

}