<?php
require_once 'Models/Model.php';
require_once 'Models/Review.php';
class Product extends Modele implements JsonSerializable
{
    /**
     * Unique id
     * @var int
     */
    private int $id;

    /**
     * catId
     * @var int
     */
    private int $catId;

    /**
     * name
     * @var string
     */
    private string $name;

    /**
     * description
     * @var string
     */
    private string $description;

    /**
     * image
     * @var string
     */
    private string $image;

    /**
     * price
     * @var float
     */
    private float $price;

    /**
     * total quantity available
     * @var int
     */
    private int $quantity;

    /**
     * quantityRemaining = quantity - basketsorders
     * @var int
     */
    private int $quantityRemaining;

    /**
     * all review linked
     * @var Review[]|null
     */
    private array |null $reviews = null;

    /**
     * Constructor
     * @param mixed $data
     */
    protected function __construct($data)
    {
        $this->id = $data['id'];
        $this->catId = $data['cat_id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->image = $data['image'];
        $this->price = $data['price'];
        $this->quantityRemaining = $data['quantity_remaining'];
        $this->quantity = $data['quantity'];
    }

    /**
     * Return all Products
     * @return Product[]
     */
    public static function getAllProducts(): array
    {
        $sql = 'select * from viewProduct';
        return Product::fetchAll($sql);
    }

    /**
     * Return products by id list
     * @param int[] $ids
     * @return array
     */
    public static function getProductsByIds(array $ids)
    {
        $placeholders = str_repeat('?, ',  count($ids) - 1) . '?';
        $sql = "select * from viewProduct wehre id in ($placeholders);";
        return Product::fetchAll($sql, $ids);
    }

    /**
     * Return product by id
     * @param int $id
     * @return Product|null
     */
    public static function getProductById(int $id): ?Product
    {
        if (self::getInstanceById($id)) {
            return self::getInstanceById($id);
        }
        $sql = 'select * from viewProduct where id=:id';
        return Product::fetch($sql, [":id" => $id]);
    }


    public static function getAllProductsByCategorieId($id)
    {
        $sql = 'select * from viewProduct where cat_id=:cat_id';
        return Product::fetchAll($sql, [":cat_id" => $id]);
    }

    public static function getProductsByNameLike($name)
    {
        //FIXME: Bug de limit dans la requete preparé, impossible de passer en parametre sans erreur
        $sql = 'select * FROM viewProduct where name LIKE :name LIMIT 5';
        return Product::fetchAll($sql, [":name" => "%" . $name . "%"]);
    }

    public function save(): self
    {
        $sql = "UPDATE products SET cat_id=:cat_id,name=:name,description=:description,image=:image,price=:price,quantity=:quantity WHERE id=:id;";
        self::executeRequest($sql, [
            ":cat_id" => $this->getCatId(),
            ":name" => $this->getName(),
            ":description" => $this->getDescription(),
            ":image" => $this->getImage(),
            ":price" => $this->getPrice(),
            ":quantity" => $this->getQuantity(),
            ":id" => $this->getId(),
        ]);
        return $this;
    }

    public function getReviews(): array
    {
        if ($this->reviews == null) {
            $this->reviews = Review::getReviewByProductId($this->getId());
        }
        return $this->reviews;
    }

    public function getCategorie()
    {
        return Categorie::GetCategorieById($this->catId);
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

    /**
     * quantityRemaining
     * @param int $quantityRemaining quantityRemaining
     * @return self
     */
    public function setQuantityRemaining(int $quantityRemaining): self
    {
        $this->quantityRemaining = $quantityRemaining;
        return $this;
    }

    /**
     * total quantity available
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * total quantity available
     * @param int $quantity total quantity available
     * @throws ErrorException
     * @return self
     */
    public function setQuantity(int $quantity): self
    {
        if ($quantity < 0)
            throw new ErrorException("Quantity cannot be negative");
        $this->quantity = $quantity;
        return $this;
    }
}
