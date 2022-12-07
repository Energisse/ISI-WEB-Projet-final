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

    public static function getAllProducts()
    {
        $sql = 'select * from products';
        $categories = Product::executerRequete($sql);
        $listeCategorie = [];
        foreach ($categories->fetchAll() as $categorie) {
            array_push($listeCategorie, new Categorie($categorie));
        }
        return $listeCategorie;
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
}
