<?php
require_once 'Models/Model.php';
require_once 'Models/Product.php';

class OrderStatus extends Modele
{
    private int $statusCode;
    private int $orderId;
    private string $date;

    function __construct($data)
    {
        $this->statusCode = $data['status'];
        $this->date = $data['date'];
        $this->orderId = $data['order_id'];
    }

    public static function createNewStatus($order_id){
        $sql = "insert into orderstatus (order_id) values (:order_id);";
        OrderStatus::executerRequete($sql, [":order_id" => $order_id]);
    }

    public static function changeStatus($order_id,$status_code){
        $sql = "insert into orderstatus (order_id,status) values (:order_id,:status_code);";
        OrderStatus::executerRequete($sql, [":order_id" => $order_id,":status_code"=>$status_code]);
    
    }


    public static function getAllStatusByOrderId(int $order_id){
        $sql = "SELECT * FROM `orderstatus` WHERE order_id = :order_id";
        $result = OrderStatus::executerRequete($sql, [":order_id" => $order_id]);
        $listeOrdersStatus = [];
        foreach ($result->fetchAll() as $order) {
            array_push($listeOrdersStatus,new OrderStatus($order));
        }
        return $listeOrdersStatus;
    }

    public static function getAllStatusByOrdersId(array $orders_id){
        $placeholders = str_repeat ('?, ',  count ($orders_id) - 1) . '?';
        $sql = "SELECT * FROM `orderstatus` where order_id in ($placeholders) ORDER BY order_id DESC ,DATE ASC";
        $result = OrderStatus::executerRequete($sql, $orders_id);
        $listeOrdersStatus = [];
        foreach ($result->fetchAll() as $order) {
            array_push($listeOrdersStatus,new OrderStatus($order));
        }
        return $listeOrdersStatus;
    }
    
	/**
	 * @return int
	 */
	public function getStatusCode(): int {
		return $this->statusCode;
	}

    /**
	 * @return int
	 */
	public function getOrderId(): int {
		return $this->orderId;
	}

	/**
	 * @return string
	 */
	public function getDate(): string {
		return $this->date;
	}
}