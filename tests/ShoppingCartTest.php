<?php

use App\ShoppingCart;
use App\ShoppingCartItem;
use PHPUnit\Framework\TestCase;

final class ShoppingCartTest extends TestCase
{
    public function testAddSingleProduct()
    {
        $productName = 'Dove Soap';
        $productPrice = 39.99;
        $shoppingCart = new ShoppingCart();
        $shoppingCart->addProduct($productName, $productPrice);
        $cartItems = $shoppingCart->getItems();

        $this->assertEquals(39.99, $shoppingCart->totalPrice());
        $this->assertShoppingCartItems($cartItems, [
            [
                'name' => $productName,
                'price' => $productPrice,
                'total' => 39.99,
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
}
