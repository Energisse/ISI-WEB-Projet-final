<?php
require_once 'Models/Model.php';
class Product extends Modele implements JsonSerializable
{
    private int $id;
    private int $catId;
    private string $name;
    private string $description;
    private string $image;
    private float $price;
    private int $quantityRemaining;

    function __construct($data = null)
    {
        if ($data == null) return;
        $this->id = $data['id'];
        $this->catId = $data['cat_id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->image = $data['image'];
        $this->price = $data['price'];
        $this->quantityRemaining = $data['quantity_remaining'];
    }

    public static function getAllProducts(): array
    {
        $sql = 'select * from products';
        $products = Product::executerRequete($sql);
        $listeProduct = [];
        foreach ($products->fetchAll() as $product) {
            $listeProduct[] = new Product($product);
        }
        return $listeProduct;
    }

    public static function getProductsById($ids)
    {
        $placeholders = str_repeat('?, ',  count($ids) - 1) . '?';
        $sql = "select * from products wehre id in ($placeholders);";
        return Product::queryProducts($sql, $ids);
    }

    public static function getProductById($id): ?Product
    {
        $sql = 'select * from products where id=:id';
        return Product::queryProduct($sql, [":id" => $id]);
    }

    public function getCategorie()
    {
        return Categorie::GetCategorieById($this->catId);
    }

    public static function getAllProductsByCategorieId($id)
    {
        $sql = 'select * from products where cat_id=:cat_id';
        return Product::queryProducts($sql, [":cat_id" => $id]);
    }

    public static function getProductsByNameLike($name)
    {
        //FIXME: Bug de limit dans la requete preparé, impossible de passer en parametre sans erreur
        $sql = 'select * FROM products where name LIKE :name LIMIT 5';
        return Product::queryProducts($sql, [":name" => "%" . $name . "%"]);
    }

    private static function queryProducts($sql, $params = null)
    {
        $products = Product::executerRequete($sql, $params);
        return $products->fetchAll(PDO::FETCH_CLASS, 'Product');
    }

    private static function queryProduct($sql, $params = null)
    {
        $product = Product::executerRequete($sql, $params);
        $product->setFetchMode(PDO::FETCH_CLASS, 'Product');
        return $product->fetch();
    }

    public function __toString()
    {
        return 'Produit : ' . $this->name . '#' . $this->id;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * @return int
     */
    public function getCatId(): int
    {
        return $this->catId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }


    /**
     * @return int
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getQuantityRemaining(): int
    {
        return $this->quantityRemaining;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
