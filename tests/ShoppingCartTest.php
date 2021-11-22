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
        $shoppingCart->addProductWithPrice($productName, 1, $originalPrice);

        $this->assertEquals($normalizedPrice, $shoppingCart->totalPriceWithoutTax());
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
        $shoppingCart->addProductWithPrice($productName, 5, $productPrice);
        $shoppingCart->addProductWithoutPrice($productName, 3);

        $this->assertEquals(319.92, $shoppingCart->totalPriceWithoutTax());
        $this->assertShoppingCartItems($shoppingCart->getItems(), [
            [
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => 8,
                'total' => 319.92,
            ],
        ]);
    }

    public function testAddMultipleProductsWithTax()
    {
        $shoppingCart = new ShoppingCart();
        $shoppingCart->addProductWithPrice('Dove Soap', 2, 39.99);
        $shoppingCart->addProductWithPrice('Axe Deos', 2, 99.99);

        $this->assertEquals(314.96, $shoppingCart->totalPriceWitTax());
        $this->assertEquals(35, $shoppingCart->getTax());
        $this->assertShoppingCartItems($shoppingCart->getItems(), [
            [
                'name' => 'Dove Soap',
                'price' => 39.99,
                'quantity' => 2,
                'total' => round(39.99 * 2, 2),
            ],
            [
                'name' => 'Axe Deos',
                'price' => 99.99,
                'quantity' => 2,
                'total' => round(99.99 * 2, 2),
            ],
        ]);
    }

    public function testRemoveItemFromCart()
    {
        $shoppingCart = new ShoppingCart();
        $shoppingCart->addProductWithPrice('Dove Soap', 4, 39.99);
        $shoppingCart->addProductWithPrice('Axe Deos', 2, 99.99);

        $shoppingCart->removeProduct('Dove Soap', 1);

        $this->assertShoppingCartItems($shoppingCart->getItems(), [
            [
                'name' => 'Dove Soap',
                'price' => 39.99,
                'quantity' => 3,
                'total' => round(39.99 * 3, 2),
            ],
            [
                'name' => 'Axe Deos',
                'price' => 99.99,
                'quantity' => 2,
                'total' => round(99.99 * 2, 2),
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

    /**
     * @return float[][]
     */
    public function singleProductProvider()
    {
        return [
            [39.99, 39.99],
            [0.565, 0.57],
            [0.5649, 0.56],
        ];
    }
}
