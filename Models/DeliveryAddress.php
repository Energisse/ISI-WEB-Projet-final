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
         * userId
         * @var int
         */
        private int $userId;

        /**
         * previousId of edited delivery
         * @var int|null
         */
        private int|null $previousId;

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
            $this->userId = $data['user_id'];
            $this->previousId = $data['previous_id'];
        }

        /**
         * Return all delivery addresses from one user by his id
         * @param int $userId
         * @return DeliveryAddress[]
         */
        static function getAllDeliveryAddressByUserId(int $userId): array
        {
            $sql = 'select * from delivery_addresses where user_id = :user_id and active=1';
            return DeliveryAddress::fetchAll($sql, [":user_id" => $userId]);
        }

        /**
         *  Return a delivery addresses by id if link to user
         * @param int $id
         * @param int $userId
         * @return DeliveryAddress|null
         */
        static function getDeliveryAddressByIdAndUserId(int $id, int  $userId): ?DeliveryAddress
        {
            $sql = 'select * from delivery_addresses where  user_id=:user_id and id=:id and active=1';
            return DeliveryAddress::fetch($sql, [":id" => $id, ":user_id" => $userId]);
        }

        /**
         * Update a delivery
         * Create a new one if address is used in at least one order and disabled the last one
         * @param array $data
         * @param int $id
         * @param int $userId
         * @throws FormException
         * @return void
         */
        static function updateDeliveryAddressByIdAndUserId(array $data, int $id, int $userId)
        {
            $sql = '';
            $params = [];
            $params[":forename"] = self::checkForeName($data["forename"]);
            $params[":surname"] = self::checkSureName($data["surname"]);
            $params[":add1"] = self::checkAdd1($data["add1"]);
            $params[":add2"] = self::checkAdd2($data["add2"]);
            $params[":city"] = self::checkCity($data["city"]);
            $params[":postCode"] = self::checPostCode($data["postcode"]);
            $params[":phone"] = self::checkPhone($data["phone"]);
            $params[":email"] = self::checkEmail($data["email"]);
            $params[":id"] = $id;
            $params[":user_id"] = $userId;
            //If deliveryAddress is already used wee need to create a new one and disable the last one
            if (Order::getAllCountOfOrderUsedByDeliveryAddressId($id)) {
                $params[":previous_id"] = $id;
                $params[":user_id2"] = $userId;
                $sql = 'UPDATE delivery_addresses SET active=0 WHERE id=:id and user_id=:user_id2; INSERT INTO delivery_addresses (forename, surname,add1,add2,city,postCode,phone,email,user_id,previous_id) VALUES (:forename, :surname, :add1, :add2, :city, :postCode, :phone, :email ,:user_id,:previous_id)';
            } else {
                $sql = 'UPDATE delivery_addresses SET forename=:forename, surname=:surname, add1=:add1, add2=:add2, city=:city, postCode=:postCode, phone=:phone, email=:email WHERE id=:id and user_id=:user_id';
            }
            DeliveryAddress::executeRequest($sql, $params);
        }

        /**
         * Create a new delivery
         * @param array $data
         * @param int $userId
         * @throws FormException
         * @return void
         */
        static function createDeliveryAddress(array $data, int $userId)
        {
            $sql = 'INSERT INTO delivery_addresses (forename, surname,add1,add2,city,postCode,phone,email,user_id) VALUES (:forename, :surname, :add1, :add2, :city, :postCode, :phone, :email ,:user_id)';
            $params = [];
            $params[":forename"] = self::checkForeName($data["forename"]);
            $params[":surname"] = self::checkSureName($data["surname"]);
            $params[":add1"] = self::checkAdd1($data["add1"]);
            $params[":add2"] = self::checkAdd2($data["add2"]);
            $params[":city"] = self::checkCity($data["city"]);
            $params[":postCode"] = self::checPostCode($data["postcode"]);
            $params[":phone"] = self::checkPhone($data["phone"]);
            $params[":email"] = self::checkEmail($data["email"]);
            $params[":user_id"] = $userId;
            DeliveryAddress::executeRequest($sql, $params);
        }

        /**
         * Delete delivery address if note used in at least one order else disabled it
         * @param int $id
         * @param int $userId
         * @return void
         */
        static function deleteDeliveryAddressByIdAndUserId(int $id, int $userId)
        {
            $params = [];
            $sql = "";
            $params[":id"] = $id;
            $params[":user_id"] = $userId;
            if (Order::getAllCountOfOrderUsedByDeliveryAddressId($id)) {
                $sql = 'UPDATE delivery_addresses SET active=0 WHERE id=:id and user_id=:user_id;';
            } else {
                $sql = 'DELETE from delivery_addresses WHERE id=:id and user_id=:user_id;';
            }
            DeliveryAddress::executeRequest($sql, $params);
        }

        /**
         * Return a delivery address by Id
         * @param int $id
         * @return DeliveryAddress
         */
        static function getDeliveryAddressById(int $id): DeliveryAddress|null
        {
            if (self::getInstanceByID($id)) {
                return self::getInstanceByID($id);
            }
            $sql = 'select * from delivery_addresses where id=:id';
            return DeliveryAddress::fetch($sql, [":id" => $id])->fetch();
        }

        /**
         * Return user link to this address
         * @return User|null
         */
        public function getUser()
        {
            return User::getUserById($this->getUserId());
        }

        /**
         * check forename length between 3 and 50 and chop it
         * @param mixed $forename
         * @throws FormException
         * @return string
         */
        public static function checkForeName(mixed $forename): string
        {
            $forename = chop($forename);
            self::checkLengthBetween($forename, 3, 50, "forename");
            return $forename;
        }

        /**
         * check surname length between 3 and 50 and chop it
         * @param mixed $surname
         * @throws FormException
         * @return string
         */
        public static function checkSureName(mixed $surname): string
        {
            $surname = chop($surname);
            self::checkLengthBetween($surname, 3, 50, "surname");
            return $surname;
        }

        /**
         * check add1 length between 3 and 50 and chop it
         * @param mixed $add1
         * @throws FormException
         * @return string
         */
        public static function checkAdd1(mixed $add1): string
        {
            $add1 = chop($add1);
            self::checkLengthBetween($add1, 3, 50, "add1");
            return $add1;
        }

        /**
         *  check add2 length between 3 and 50 and chop it
         * @param mixed $add2
         * @throws FormException
         * @return string
         */
        public static function checkAdd2(mixed $add2): string
        {
            $add2 = chop($add2);
            self::checkLengthBetween($add2, 0, 50, "add2");
            return $add2;
        }

        /**
         *  check city length between 1 and 50 and chop it
         * @param mixed $city
         * @throws FormException
         * @return string
         */
        public static function checkCity(mixed $city): string
        {
            $city = chop($city);
            self::checkLengthBetween($city, 1, 50, "city");
            return $city;
        }

        /**
         *  check postcode is between 0 and 99999
         * @param mixed $postCode
         * @throws FormException
         * @return string
         */
        public static function checPostCode(mixed $postCode): string
        {
            $postCode = chop($postCode);
            self::checkValueBetween($postCode, 0, 99999, "postcode");
            return $postCode;
        }

        /**
         *  check phone number and format it
         * @param mixed $phone
         * @throws FormException
         * @return string
         */
        public static function checkPhone(mixed $phone)
        {
            $phone = chop($phone);
            if (!preg_match("/0?[1-9]\s?\d{2}\s?\d{2}\s?\d{2}\s?\d{2}/", $phone)) {
                throw new FormException("Email invalide", "email");
            }
            //add a 0 if no writen like ->(+33) 6 xx xx xx xx to 06 xx xx xx xx
            $phone = str_replace(" ", "", $phone);
            $phone = (strlen($phone) == 9 ? "0" : "") . $phone;
            return $phone;
        }

        /**
         * check email
         * @param mixed $email
         * @throws FormException
         * @return string
         */
        public static function checkEmail(mixed $email): string
        {
            $email = chop($email);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new FormException("Email invalide", "email");
            }
            return $email;
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
         * Get the value of userId
         *
         * @return int
         */
        public function getUserId(): int
        {
            return $this->userId;
        }
    }
