<?php

namespace App;

class ShoppingCart
{
    /**
     * @var ShoppingCartItem[]
     */
    protected $productItems = [];

    public function __construct()
    {
    }

    /**
     * @param string $productName
     * @param float $price
     * @param int $quantity
     */
    public function addProduct($productName, $price, $quantity = 1)
    {
        if (isset($this->productItems[$productName])) {
            $this->productItems[$productName]->addQuantity($quantity);
        } else {
            $this->productItems[$productName] = new ShoppingCartItem($productName, $price, $quantity);
        }
    }

    /**
     * @return ShoppingCartItem[]
     */
    public function getItems()
    {
        return $this->productItems;
    }

    public function totalPrice()
    {
        $total = 0;
        foreach ($this->productItems as $productItem) {
            $total = $total + $productItem->getTotal();
        }

        return $total;
    }
}
