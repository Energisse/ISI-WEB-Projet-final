<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';

class Categorie extends Modele
{
    private $name;
    private $id;

    function __construct($data)
    {
        $this->name = $data['name'];
        $this->id = $data['id'];
    }

    public static function getAllCategories()
    {
        $sql = 'select * from categories';
        $categories = Categorie::executerRequete($sql);
        $listeCategorie = [];
        foreach ($categories->fetchAll() as $categorie) {
            array_push($listeCategorie, new Categorie($categorie));
        }
        return $listeCategorie;
    }

    public static function getCategorieByName($name)
    {
        $sql = 'select * from categories where name=:name';
        $result = Categorie::executerRequete($sql, [':name' => $name])->fetch();
        if ($result != null) {
            $result = new Categorie($result);
        }
        return $result;
    }

    public static function getCategorieById($id)
    {
        $sql = 'select * from categories where id=:id';
        $result = Categorie::executerRequete($sql, [':id' => $id])->fetch();
        if ($result != null) {
            $result = new Categorie($result);
        }
        return $result;
    }

    public function getAllProducts()
    {
        return Product::getAllProductsByCategorieId($this->id);
    }

    public function __toString()
    {
        return 'Categorie : ' . $this->name . '#' . $this->id;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }
}