<?php
require_once 'Models/Model.php';
class Product extends Modele
{
    private $id;
    private $cat_id;
    private $name;
    private $description;
    private $image;
    private $price;
    private $quantity;

    function __construct($data)
    {
        $this->id = $data['id'];
        $this->cat_id = $data['cat_id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->image = $data['image'];
        $this->price = $data['price'];
        $this->quantity = $data['quantity'];
    }

    public static function getAllProducts(): array
    {
        $sql = 'select * from products';
        $products = Product::executerRequete($sql);
        $listeProduct = [];
        foreach ($products->fetchAll() as $product) {
            array_push($listeProduct, new Categorie($product));
        }
        return $listeProduct;
    }

    public static function getProductById($id): ?Product
    {
        $sql = 'select * from products where id=:id';
        $result = Product::executerRequete($sql, [":id" => $id])->fetch();
        if ($result == null)
            return null;
        return new Product($result);
    }


    public function getCategorie()
    {
        return Categorie::GetCategorieById($this->cat_id);
    }

    public static function getAllProductsByCategorieId($id)
    {
        $sql = 'select * from products where cat_id=:cat_id';
        $products = Product::executerRequete($sql, [':cat_id' => $id]);
        $listeProduct = [];
        foreach ($products->fetchAll() as $product) {
            array_push($listeProduct, new Product($product));
        }
        return $listeProduct;
    }

    public function __toString()
    {
        return 'Produit : ' . $this->name . '#' . $this->id;
    }


    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Get the value of image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of cat_id
     */
    public function getCat_id()
    {
        return $this->cat_id;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }
}