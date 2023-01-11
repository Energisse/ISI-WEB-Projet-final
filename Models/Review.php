<?php
require_once 'Models/Model.php';
require_once 'Models/Exception.php';
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
     * Date
     * @var string
     */
    private string $date;


    /**
     * Constructor
     * @param mixed $data
     */
    protected function __construct($data)
    {
        $this->productId = $data['product_id'];
        $this->userId = $data['user_id'];
        $this->stars = $data['stars'];
        $this->description = $data['description'];
        $this->title = $data['title'];
        $this->date = $data['date'];
    }

    /**
     * Return all reviews by product id
     * @param int $productId
     * @return Review[]
     */
    public static function getReviewByProductId(int $productId): array
    {
        $sql = 'SELECT * FROM reviews where product_id=:product_id';
        return self::fetchAll($sql, [":product_id" => $productId]);
    }

    /**
     * Return all reviews by product id and user id
     * @param int $productId
     * @return Review[]
     */
    public static function getReviewByProductIdAndUserId(int $productId, int $userId): Review
    {
        $sql = 'SELECT * FROM reviews where product_id=:product_id and user_id=:user_id';
        return self::fetch($sql, [":product_id" => $productId, ":user_id" => $userId]);
    }

    /**
     * Create a Review if the user never post a review, else edit 
     * @param int $productId
     * @param int $userId
     * @param array $data
     * @return void
     */
    public static function createOrEditReviewByProductIdANdUserId(int $productId, int $userId, array $data)
    {
        //TODO: ADD verifcation for data before insert
        $sql = 'INSERT INTO reviews (product_id,user_id,title, stars, description) VALUES(:product_id,:user_id,:title,:stars,:description) ON DUPLICATE KEY UPDATE title=:title,description=:description, stars=:stars, date=now()';
        self::fetch($sql, [
            ":product_id" => $productId,
            ":user_id" => $userId,
            ":title" =>  self::checkTitle($data["title"]),
            ":stars" => self::checkStars($data["stars"]),
            ":description" =>  self::checkDescription($data["description"])
        ]);
    }

    /**
     * Check if stars is between 1 and 5
     * @param string $description
     * @throws AttributException
     * @return string
     */
    public static function checkStars(int $stars): int
    {
        if ($stars < 1) {
            throw new AttributException("La note doit être supérieur ou égale à 1", "stars");
        } else if ($stars > 5) {
            throw new AttributException("La note doit être inferieur ou égale à 5", "stars");
        }
        return $stars;
    }

    /**
     * Check if description length is between 10 and 255
     * @param string $description
     * @throws AttributException
     * @return string
     */
    public static function checkDescription(string $description): string
    {
        $length = mb_strlen($description, "utf-8");
        if ($length < 10) {
            throw new AttributException("La description doit au moins faire 10 caractères", "description");
        } else if ($length > 256) {
            throw new AttributException("La description ne doit pas faire plus de 255 caractères", "description");
        }
        return $description;
    }

    /**
     * Check if title length is between 10 and 50
     * @param string $title
     * @throws AttributException
     * @return string
     */
    public static function checkTitle(string $title): string
    {
        $length = mb_strlen($title, "utf-8");
        if ($length < 5) {
            throw new AttributException("Le titre doit au moins faire 10 caractères", "title");
        } else if ($length  > 50) {
            throw new AttributException("Le titre ne doit pas faire plus de 50 caractères", "title");
        }
        return $title;
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
     * Return User linked
     * @return ?User
     */
    public function getUser(): ?User
    {
        return User::getUserById($this->getUserId());
    }

    /**
     * productId unique couple with userId
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * userId unique couple with productId
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * stars
     * @return int
     */
    public function getStars(): int
    {
        return $this->stars;
    }

    /**
     * title
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * description
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    public function getId()
    {
        return $this->productId . "-" . $this->userId;
    }

    /**
     * Date
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }
}
