<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';

class Categorie extends Modele
{
    /**
     * Unique Id
     * @var int
     */
    private int $id;

    /**
     * name
     * @var string
     */
    private string $name;

    /**
     * every Products linked  
     * @var Product[]|null
     */
    private array|null $products = null;

    /**
     * Constructor
     * @param mixed $data
     */
    protected function __construct($data)
    {
        $this->name = $data['name'];
        $this->id = $data['id'];
    }

    /**
     * Return all Categorie
     * @return Categorie[]
     */
    public static function getAllCategories():array
    {
        $sql = 'select * from categories';
        return Categorie::fetchAll($sql);
    }

    /**
     * Return a categorie by his name
     * @param string $name
     * @return Categorie|null
     */
    public static function getCategorieByName(string $name):?Categorie
    {
        $sql = 'select * from categories where name=:name';
        return Categorie::fetch($sql);
    }

    /**
     * Return a categorie by his id
     * @param int $id
     * @return Categorie|null
     */
    public static function getCategorieById(int $id):?Categorie
    {
        if(self::getInstanceByID($id)){
            return self::getInstanceByID($id);
        }
        $sql = 'select * from categories where id=:id';
        return Categorie::fetch($sql, [':id' => $id]);
    }

    /**
     * Return all product from this array
     * @return Product[]
     */
    public function getAllProducts():array
    {
        if($this->products == null){
            $this->products = Product::getAllProductsByCategorieId($this->id);
        }
        return $this->products;
    }

	/**
	 * Unique Id
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * name
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

}
