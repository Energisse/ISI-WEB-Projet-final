<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';

class DeliveryAddress extends Modele
{
    private $id;
    private $foreName;
    private $surName;
    private $add1;
    private $add2;
    private $add3;
    private $postCode;
    private $phone;
    private $email;

    function __construct($data)
    {
    
    }

    function getAllDeliveryAddressByUserId($id){
        $sql = 'select * from delivery_addresses where customer_id = :customer_id';
        $deliverys = DeliveryAddress::executerRequete($sql, [":customer_id"=>$id]);
        $listeDeliveryAddress = [];
        foreach ($deliverys->fetchAll() as $delivery) {
            print_r($delivery)
        }
        return $listeDeliveryAddress;
    }

}