<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';

class Login extends Modele
{
    private string $username;
    private int $id;

    private string $password;

    private bool $admin;

    function __construct($data)
    {
        $this->username = $data['username'];
        $this->id = $data['id'];
        $this->password = $data['password'];
        $this->admin = $data['admin'];
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


	/**
	 * @return mixed
	 */
	public function getUsername() {
		return $this->username;
	}


	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

    public function isAdmin(){
        return $this->admin;
    }
}