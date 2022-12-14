<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';

class OrderItem extends Modele
{
    private $id;
    private $user_id;
    private $deliverryAddressId;
    private $quantity;

    function __construct($data)
    {
    }
}