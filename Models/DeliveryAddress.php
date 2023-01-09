    <?php
    require_once 'Models/Model.php';
    require_once 'Models/Product.php';

    class DeliveryAddress extends Modele
    {
        /**
         * Unique Id
         * @var int
         */
        private int $id;

        /**
         * forename
         * @var string
         */
        private string $forename;
       
        /**
         * surname
         * @var string
         */
        private string $surname;

        /**
         * add1
         * @var string
         */
        private string $add1;

        /**
         * add2
         * @var string
         */
        private string $add2;

        /**
         * city
         * @var string
         */
        private string $city;

        /**
         * postcode
         * @var string
         */
        private string $postcode;

        /**
         * phone
         * @var string
         */
        private string $phone;

        /**
         * email
         * @var string
         */
        private string $email;

        /**
         * user_id
         * @var int
         */
        private int $user_id;

        /**
         * Constructor
         * @param mixed $data
         */
        protected function __construct($data = null)
        {
            DeliveryAddress::$instances[strval($data['id'])] = $this;
            $this->id = $data['id'];
            $this->forename = $data['forename'];
            $this->surname = $data['surname'];
            $this->add1 = $data['add1'];
            $this->add2 = $data['add2'];
            $this->city = $data['city'];
            $this->postcode = $data['postcode'];
            $this->phone = $data['phone'];
            $this->email = $data['email'];
            $this->user_id = $data['user_id'];
        }

        /**
         * Return all delivery addresses from one user by his id
         * @param int $user_id
         * @return DeliveryAddress[]
         */
        static function getAllDeliveryAddressByUserId(int $user_id):array
        {
            $sql = 'select * from delivery_addresses where user_id = :user_id';
            return DeliveryAddress::fetchAll($sql, [":user_id" => $user_id]);
        }

        /**
         *  Return a delivery addresses by id if link to user
         * @param int $id
         * @param int $user_id
         * @return DeliveryAddress|null
         */
        static function getDeliveryAddressByIdAndUserId(int $id,int  $user_id): ?DeliveryAddress
        {
            $sql = 'select * from delivery_addresses where  user_id = :user_id and id=:id';
            return DeliveryAddress::fetch($sql, [":id" => $id, ":user_id" => $user_id])->fetch();
        }

        /**
         * Update a delivery
         * @param object $data
         * @param int $id
         * @param int $user_id
         * @return void
         */
        static function updateDeliveryAddressByIdAndUserId(object $data,int $id,int $user_id)
        {
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
            DeliveryAddress::executeRequest($sql, $params);
        }

        /**
         * Create a new delivery
         * @param object $data
         * @param int $user_id
         * @return void
         */
        static function createDeliveryAddress(object $data,int $user_id)
        {
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
            DeliveryAddress::executeRequest($sql, $params);
        }
        
        static function getAllDeliveryAddressById(int $id){
            if(self::getInstanceByID($id)){
                return self::getInstanceByID($id);
            }
            $sql = 'select * from delivery_addresses where id=:id';
            return DeliveryAddress::fetch($sql, [":id" => $id])->fetch();
        }


        /**
         * Return user link to this address
         * @return User|null
         */
        public function getUser(){
            return User::getUserById($this->getUserId());
        }

        /**
         * Get the value of id
         * @return int
         */
        public function getId(): int
        {
            return $this->id;
        }

        /**
         * Get the value of forename
         *
         * @return string
         */
        public function getForeName(): string
        {
            return $this->forename;
        }

        /**
         * Get the value of surname
         *
         * @return string
         */
        public function getSurName(): string
        {
            return $this->surname;
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
         * Get the value of postcode
         *
         * @return string
         */
        public function getPostCode(): string
        {
            return $this->postcode;
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