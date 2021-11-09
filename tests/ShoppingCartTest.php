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
        $shoppingCart->addProduct($productName, 1, $originalPrice);

        $this->assertEquals($normalizedPrice, $shoppingCart->totalPrice());
        $this->assertShoppingCartItems($shoppingCart->getItems(), [
            [
                'name' => $productName,
                'price' => $normalizedPrice,
                'quantity' => 1,
                'total' => $normalizedPrice,
            ],
        ]);
    }

    public function testAddMultipleProducts()
    {
        $productName = 'Dove Soap';
        $productPrice = 39.99;
        $shoppingCart = new ShoppingCart();
        $shoppingCart->addProduct($productName, 5, $productPrice);
        $shoppingCart->addProduct($productName, 3);

        $this->assertEquals(319.92, $shoppingCart->totalPrice());
        $this->assertShoppingCartItems($shoppingCart->getItems(), [
            [
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => 8,
                'total' => 319.92,
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
            $this->assertEquals($expectedItem->getQuantity(), $actualItems[$index]['quantity']);
            $this->assertEquals($expectedItem->getTotal(), $actualItems[$index]['total']);
            $index = $index + 1;
        }
    }

    public function singleProductProvider()
    {
        return [
            [39.99, 39.99],
            [0.565, 0.57],
            [0.5649, 0.56],
        ];
    }
}
