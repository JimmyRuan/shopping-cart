<?php

namespace App;

class ShoppingCartItem
{
    const DOVE_SOAP = 'Dove Soap';
    const AXE_DEOS = 'Axe Deos';

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

    protected $minimumDiscountUnits;

    /**
     * ShoppingCartItem constructor.
     * @param string $productName
     * @param float $price
     * @param int $quantity
     * @param int $minimumDiscountUnits
     */
    public function __construct($productName, $price, $quantity, $minimumDiscountUnits=0)
    {
        $this->productName = $productName;
        $this->quantity = $quantity;
        $this->setPrice($price);

        if($minimumDiscountUnits == 3){
            echo "I am at 41";
        }

        $this->minimumDiscountUnits = $minimumDiscountUnits;
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
            $this->changeQuantity($quantity);
        }
        return $this;
    }

    /**
     * @param int $quantity
     */
    public function removeQuantity($quantity)
    {
        if ($quantity >= 1) {
            $this->changeQuantity(-1 * $quantity);
        }
        return $this;
    }



    /**
     * @return float
     */
    public function getTotal()
    {
        $amountBeforeDiscount = round($this->price * $this->quantity, 2);

        $discountedAmount = 0;
        if($this->minimumDiscountUnits > 1){
            echo "do I get a discount?";
            $discountedAmount = ($this->quantity / $this->minimumDiscountUnits) * $this->price;
        }

        return $amountBeforeDiscount - $discountedAmount;
    }

    /**
     * @param float $price
     */
    protected function setPrice($price)
    {
        $this->price = round($price, 2);
    }

    /**
     * @param $changedQuantity
     */
    protected function changeQuantity($changedQuantity)
    {
        $this->quantity = $this->quantity + $changedQuantity;
    }
}
