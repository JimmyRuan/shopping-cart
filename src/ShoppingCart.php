<?php

namespace App;

class ShoppingCart
{
    /**
     * @var ShoppingCartItem[]
     */
    protected $productItems = [];

    public const PRODUCT_TAX_RATE = 0.125;

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

    /**
     * @return float
     */
    public function getTax()
    {
        return round($this->totalPriceWithoutTax() * self::PRODUCT_TAX_RATE, 2);
    }

    /**
     * @return float
     */
    public function totalPriceWithoutTax()
    {
        $total = 0;
        foreach ($this->productItems as $productItem) {
            $total = $total + $productItem->getTotal();
        }

        return $total;
    }

    /**
     * @return float
     */
    public function totalPriceWitTax()
    {
        return $this->totalPriceWithoutTax() + $this->getTax();
    }
}
