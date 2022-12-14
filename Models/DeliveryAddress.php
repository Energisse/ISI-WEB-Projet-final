<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';

class DeliveryAddress extends Modele
{
    private int $id;
    private string $foreName;
    private string $surName;
    private string $add1;
    private string $add2;
    private string $add3;
    private string $city;
    private string $postCode;
    private string $phone;
    private string $email;
    private int $user_id;

    function __construct($data)
    {
        $this->id = $data['id'];
        $this->foreName = $data['forename'];
        $this->surName = $data['surname'];
        $this->add1 = $data['add1'];
        $this->add2 = $data['add2'];
        $this->add3 = $data['add3'];
        $this->city = $data['city'];
        $this->postCode = $data['postcode'];
        $this->phone = $data['phone'];
        $this->email = $data['email'];
        $this->user_id = $data['user_id'];
    }

    static function getAllDeliveryAddressByUserId($id){
        $sql = 'select * from delivery_addresses where user_id = :user_id';
        $deliverys = DeliveryAddress::executerRequete($sql, [":user_id"=>$id]);
        $listeDeliveryAddress = [];
        foreach ($deliverys->fetchAll() as $delivery) {
            array_push($listeDeliveryAddress,new DeliveryAddress($delivery));
        }
        return $listeDeliveryAddress;
    }

    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of foreName
     *
     * @return string
     */
    public function getForeName(): string
    {
        return $this->foreName;
    }

    /**
     * Get the value of surName
     *
     * @return string
     */
    public function getSurName(): string
    {
        return $this->surName;
    }

    /**
     * Get the value of add1
     *
     * @return string
     */
    public function getAdd1(): string
    {
        return $this->add1;
    }

    /**
     * Get the value of add2
     *
     * @return string
     */
    public function getAdd2(): string
    {
        return $this->add2;
    }

    /**
     * Get the value of city
     *
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Get the value of postCode
     *
     * @return string
     */
    public function getPostCode(): string
    {
        return $this->postCode;
    }

    /**
     * Get the value of phone
     *
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * Get the value of email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Get the value of user_id
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * Get the value of add3
     *
     * @return string
     */
    public function getAdd3(): string
    {
        return $this->add3;
    }
}