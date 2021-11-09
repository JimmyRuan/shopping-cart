<?php

namespace App;

class ShoppingCartItem
{
    /**
     * @var float
     */
    protected $price;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var string
     */
    protected $productName;

    /**
     * ShoppingCartItem constructor.
     * @param string $productName
     * @param float $price
     * @param int $quantity
     */
    public function __construct($productName, $price, $quantity)
    {
        $this->productName = $productName;
        $this->quantity = $quantity;
        $this->setPrice($price);
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->productName;
    }

    /**
     * @param int $quantity
     */
    public function addQuantity($quantity)
    {
        if ($quantity >= 1) {
            $this->quantity = $this->quantity + $quantity;
        }
    }

    public function getTotal()
    {
        return round($this->price * $this->quantity, 2);
    }

    /**
     * @param float $price
     */
    protected function setPrice($price)
    {
        $this->price = round($price, 2);
    }
}
