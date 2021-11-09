<?php

use App\ShoppingCart;
use App\ShoppingCartItem;
use PHPUnit\Framework\TestCase;

final class ShoppingCartTest extends TestCase
{
    /**
     * @dataProvider singleProductProvider
     * @param float $originalPrice
     * @param float $normalizedPrice
     */
    public function testAddSingleProduct($originalPrice, $normalizedPrice)
    {
        $productName = 'Dove Soap';
        $shoppingCart = new ShoppingCart();
        $shoppingCart->addProduct($productName, $originalPrice);
        $cartItems = $shoppingCart->getItems();

        $this->assertEquals($normalizedPrice, $shoppingCart->totalPrice());
        $this->assertShoppingCartItems($cartItems, [
            [
                'name' => $productName,
                'price' => $normalizedPrice,
                'total' => $normalizedPrice,
            ],
        ]);
    }


    /**
     * @param ShoppingCartItem[] $expectedItems
     * @param array $actualItems
     */
    protected function assertShoppingCartItems($expectedItems, $actualItems)
    {
        $index = 0;
        foreach ($expectedItems as $expectedItem) {
            $this->assertEquals($expectedItem->getName(), $actualItems[$index]['name']);
            $this->assertEquals($expectedItem->getPrice(), $actualItems[$index]['price']);
            $this->assertEquals($expectedItem->getTotal(), $actualItems[$index]['total']);
            $index = $index + 1;
        }
    }

    public function singleProductProvider()
    {
        return [
            [39.99, 39.99],
            [0.565, 0.57],
            [0.5649, 0.56]
        ];
    }
}
