<?php

require_once("Models/Product.php");

class Basket
{

    private $products = [];

    private $quantity = 0;

    private $price = 0;

    function __construct()
    {
    }

    public function clear()
    {
        $this->quantity = 0;
        $this->price = 0;
        $this->products = [];
    }

    public function addProduct(Product $product, int $quantity = 1)
    {
        if ($quantity < 1)
            return;
        $this->quantity += $quantity;
        $this->price += $product->getPrice() * $quantity;
        if (isset($this->products[$product->getId()])) {
            $this->products[$product->getId()]["quantity"] += $quantity;
        } else {
            $this->products[$product->getId()] = ["quantity" => $quantity, "product" => $product];
        }
    }

    /**
     * Get the value of products
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }
}
