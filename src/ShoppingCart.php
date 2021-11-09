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
     * @param float|null $price
     * @param int $quantity
     */
    public function addProduct($productName, $quantity = 1, $price = null)
    {
        if (isset($this->productItems[$productName])) {
            $this->productItems[$productName]->addQuantity($quantity);
        } else {
            if ($price !== null) {
                $this->productItems[$productName] = new ShoppingCartItem($productName, $price, $quantity);
            }
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
