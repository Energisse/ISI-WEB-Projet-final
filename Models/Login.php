<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';

class Login extends Modele
{
    private $username;
    private $id;

    private $role;

    private $password;

    function __construct($data)
    {
        $this->username = $data['username'];
        $this->id = $data['id'];
        $this->role = $data['role'];
        $this->password = $data['password'];
    }

    public static function getLoginByUsernameAndPassword($username, $password): ?Login
    {
        $login = Login::getLoginByUserName($username);
        if ($login == null)
            return null;
        if (password_verify($password, $login->password)) {
            return $login;
        }
        return null;
    }

    function getAllDeliveryAddress(){
        return DeliveryAddress::getAllDeliveryAddressByUserId($this->id);
    }

    public static function getLoginByUserName(string $username): ?Login
    {
        $sql = 'select * from logins where username=:username';
        $result = Login::executerRequete($sql, [":username" => $username])->fetch();
        if ($result == null)
            return null;
        return new Login($result);
    }

}