<?php
require_once 'Models/Model.php';
class Product extends Modele
{
    private int $id;
    private int $catId;
    private string $name;
    private string $description;
    private string $image;
    private float $price;
    private int $quantityRemaining;

    function __construct($data)
    {
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

    public static function getProductsById($ids): array
    {
        $placeholders = str_repeat ('?, ',  count ($ids) - 1) . '?';
        $sql = "select * from products wehre id in ($placeholders);";
        $products = Product::executerRequete($sql,$ids);
        $listeProduct = [];
        foreach ($products->fetchAll() as $product) {
            $listeProduct[] = new Product($product);
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
	 * @return int
	 */
	public function getCatId(): int {
		return $this->catId;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getDescription(): string {
		return $this->description;
	}

	/**
	 * @return string
	 */
	public function getImage(): string {
		return $this->image;
	}


    /**
	 * @return int
	 */
	public function getPrice(): string {
		return $this->price;
	}

	/**
	 * @return int
	 */
	public function getQuantityRemaining(): int {
		return $this->quantityRemaining;
	}

	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}
}