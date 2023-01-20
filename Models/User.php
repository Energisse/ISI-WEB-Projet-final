<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';

/**
 * User class of every user  (customer & admin) 
 */
class User extends Modele
{
    /**
     * Unique id
     * @var int
     */
    private int $id;

    //FIXME: USERNAME SHOULD BE UNIQUE
    /**
     * Username
     * @var string
     */
    private string $username;

    /**
     * password hashed
     * @var string
     */
    private string $password;

    /**
     * Is admin
     * @var bool
     */
    private bool $admin;

    /**
     * profil image
     * @var string
     */
    private string $image;

    /**
     * All deliveryAddresses link to this user
     * @var DeliveryAddress[]|null
     */
    private array|null $deliveryAddresses = null;

    /**
     * All orders link to this user
     * @var Order[]|null
     */
    private array|null $orders = null;


    function __construct($data = null)
    {
        if ($data == null) return;
        $this->username = $data['username'];
        $this->id = $data['id'];
        $this->password = $data['password'];
        $this->admin = $data['admin'];
        $this->image = $data['image'];
    }

    /**
     * Return a User if username and password match
     * @param string $username
     * @param string $password
     * @return User|null
     */
    public static function getUserByUsernameAndPassword(string $username, string $password): ?User
    {
        $User = User::getUserByUserName($username);
        if ($User == null)
            return null;
        if (password_verify($password, $User->password)) {
            return $User;
        }
        return null;
    }

    /**
     * Return a User by username
     * @param string $username
     * @return User|null
     */
    public static function getUserByUserName(string $username): ?User
    {
        $sql = 'select * from Users where username=:username';
        return User::fetch($sql, [":username" => $username]);
    }


    /**
     * Insert a new user and log in
     * @param string $username
     * @param string $password
     * @return User
     */
    public static function signin(string $username, string $password): User
    {
        $sql = 'insert into users(username,password) values(:username,:password)';
        User::executeRequest($sql, [":username" => htmlspecialchars($username), ":password" => password_hash($password, PASSWORD_BCRYPT)]);
        return User::fetch("select * from Users where id=?", [User::lastInsertId()]);
    }

    /** 
     * Return a User by id
     * @param int $id
     * @return User|null
     */
    public static function getUserById(string $id): ?User
    {
        if (self::getInstanceByID($id)) {
            return self::getInstanceByID($id);
        }
        $sql = 'select * from Users where id=:id';
        return User::fetch($sql, [":id" => $id]);
    }

    /**
     * Return all delivery address link to this user
     * @return DeliveryAddress[]
     */
    function getAllDeliveryAddress(): array
    {
        if ($this->deliveryAddresses == null) {
            $this->deliveryAddresses = DeliveryAddress::getAllDeliveryAddressByUserId($this->id);
        }
        return $this->deliveryAddresses;
    }

    /**
     * Return all order link to this user
     * @return Order[]
     */
    function getAllOrder(): array
    {
        if ($this->orders == null) {
            $this->orders = Order::getOrdersByUserId($this->id);
        }
        return $this->orders;
    }

    /**
     * Unique id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Username
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * if user is admin
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->admin;
    }

    /**
     * profil image
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }
}
