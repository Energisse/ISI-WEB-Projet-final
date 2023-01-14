<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';

//No enum in php 8 (only php 8.1 :( )
class OrderStatusCode
{
    static $InPurchase = 0;
    static $InPayment = 1;
    static $WaintingPayment = 2;
    static $Paid = 3;
    static $InDelivery = 4;
    static $Delivered = 5;
};


class OrderStatus extends Modele
{
    /**
     * Status  unique couple with order_id
     * @var int
     */
    private int $status;

    /**
     * order_id unique couple with status
     * @var int
     */
    private int $order_id;

    /**
     * date
     * @var DateTime
     */
    private DateTime $date;

    /**
     * Constructor
     * @param mixed $data
     */
    protected function __construct($data)
    {
        $this->status = $data["status"];
        $this->order_id = $data["order_id"];
        $this->date = date_create($data["date"]);
    }

    /**
     * Create a NewStatus and store it in database
     * @param int $order_id
     * @return void
     */
    public static function createNewStatus(int $order_id)
    {
        $sql = "insert into orderstatus (order_id) values (:order_id);";
        OrderStatus::executeRequest($sql, [":order_id" => $order_id]);
    }

    /**
     * Change status and store it in database
     * @param int $order_id
     * @param int $status_code
     * @return void
     */
    public static function changeStatus(int $order_id, int $status_code)
    {
        $sql = "delete from orderstatus where order_id=:order_id and  status >= :status_code; insert into orderstatus (order_id,status) values (:order_id,:status_code);";
        OrderStatus::executeRequest($sql, [":order_id" => $order_id, ":status_code" => $status_code]);
    }


    /**
     * return all status by orderId
     * @param int $order_id
     * @return array
     */
    public static function getAllStatusByOrderId(int $order_id)
    {
        $sql = "SELECT * FROM `orderstatus` WHERE order_id = :order_id";
        return OrderStatus::fetchAll($sql, [":order_id" => $order_id]);
    }

    public static function getOrderStatusByOrderId(int $order_id)
    {
        $sql = 'SELECT * from orderstatus where date = ( SELECT Max(date) FROM orderStatus where order_id= :order_id) and order_id=:order_id';
        return OrderStatus::fetch($sql, [":order_id" => $order_id]);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->order_id;
    }

    /**
     * Return order linked
     * @return Order|null
     */
    public function getOrder()
    {
        return Order::getOrderById($this->getOrderId());
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getId()
    {
        return $this->getOrderId() . "-" . $this->getStatusCode();
    }
}
