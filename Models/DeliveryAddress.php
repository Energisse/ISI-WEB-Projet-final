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
        $this->city = $data['city'];
        $this->postCode = $data['postcode'];
        $this->phone = $data['phone'];
        $this->email = $data['email'];
        $this->user_id = $data['user_id'];
    }

    static function getAllDeliveryAddressByUserId($user_id){
        $sql = 'select * from delivery_addresses where user_id = :user_id';
        $deliverys = DeliveryAddress::executerRequete($sql, [":user_id"=>$user_id]);
        $listeDeliveryAddress = [];
        foreach ($deliverys->fetchAll() as $delivery) {
            array_push($listeDeliveryAddress,new DeliveryAddress($delivery));
        }
        return $listeDeliveryAddress;
    }

    static function getDeliveryAddressByIdAndUserId($id,$user_id): ?DeliveryAddress{
        $sql = 'select * from delivery_addresses where id=:id and user_id = :user_id';
        $delivery = DeliveryAddress::executerRequete($sql, [":id"=>$id,":user_id"=>$user_id])->fetch();
        if ($delivery == null)
            return null;
        return new DeliveryAddress($delivery);  
    }

    static function updateDeliveryAddressByIdAndUserId($data,$id,$user_id){
            $sql = 'UPDATE delivery_addresses SET forename=:forename, surname=:surname, add1=:add1, add2=:add2, city=:city, postCode=:postCode, phone=:phone, email=:email WHERE id=:id and user_id=:user_id';
            $params = [];
            $params[":forename"] = $data["forename"];
            $params[":surname"] = $data["surname"];
            $params[":add1"] = $data["add1"];
            $params[":add2"] = $data["add2"];
            $params[":city"] = $data["city"];
            $params[":postCode"] = $data["postCode"];
            $params[":phone"] = $data["phone"];
            $params[":email"] = $data["email"];
            $params[":id"] = $id;
            $params[":user_id"] = $user_id;
        DeliveryAddress::executerRequete($sql,$params)->fetch();
    }

    static function createDeliveryAddress($data,$user_id){
        $sql = 'INSERT INTO delivery_addresses (forename, surname,add1,add2,city,postCode,phone,email,user_id) VALUES (:forename, :surname, :add1, :add2, :city, :postCode, :phone, :email ,:user_id)';
        $params = [];
        $params[":forename"] = $data["forename"];
        $params[":surname"] = $data["surname"];
        $params[":add1"] = $data["add1"];
        $params[":add2"] = $data["add2"];
        $params[":city"] = $data["city"];
        $params[":postCode"] = $data["postCode"];
        $params[":phone"] = $data["phone"];
        $params[":email"] = $data["email"];
        $params[":user_id"] = $user_id;
    DeliveryAddress::executerRequete($sql,$params)->fetch();
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

}