<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';

class Review extends Modele
{
    /**
     * productId unique couple with userId
     * @var int
     */
    private int $productId;

     /**
     * userId unique couple with productId
     * @var string
     */
    private string $userId;

    /**
     * stars
     * @var int
     */
    private int $stars;
    
    /**
     * title
     * @var string
     */
    private string $title;
    
    /**
     * description
     * @var string
     */
    private string $description;
    
   
    /**
     * Constructor
     * @param mixed $data
     */
    protected function __construct($data)
    {
        $this->productId = $data['id_product'];
        $this->userId = $data['user_id'];
        $this->stars = $data['stars'];
        $this->description = $data['description'];
        $this->title = $data['title'];
    }

    /**
     * Return all reviews by product id
     * @param int $productId
     * @return Review[]
     */
    public static function getReviewByProductId(int $productId):array{
        $sql = 'SELECT * FROM reviews where id_product=:id_product';
        return self::fetchAll($sql,[":id_product"=>$productId]);
    }
  
    /**
     * Return Product linked
     * @return ?Product
     */
    public function getProduct(): ?Product
    {
        return Product::getProductById($this->getProductId());
    }

     /**
     * Return Product linked
     * @return ?Product
     */
    public function getUser(): ?Product
    {
        return User::getUserById($this->getUserId());
    }


	/**
	 * productId unique couple with userId
	 * @return int
	 */
	public function getProductId(): int {
		return $this->productId;
	}

	/**
	 * userId unique couple with productId
	 * @return string
	 */
	public function getUserId(): string {
		return $this->userId;
	}

	/**
	 * stars
	 * @return int
	 */
	public function getStars(): int {
		return $this->stars;
	}

	/**
	 * title
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}

	/**
	 * description
	 * @return string
	 */
	public function getDescription(): string {
		return $this->description;
	}

    public function getId(){
        return $this->productId . "-" . $this->userId;
    }
}
