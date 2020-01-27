<?php

class CartController
{

    /**
     * Adds product to cart synchronously
     * @param $id
     */
    public function actionAdd($id)
    {

        Cart::addProduct($id);

        // Return user to previous page
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }

    /**
     * Shows cart page
     * @return bool
     */
    public function actionIndex()
    {

        $productsInCart = false;

        $productsInCart = Cart::getProducts();

        if ($productsInCart) {
            $productsIds = array_keys($productsInCart);
            $products = Product::getProductsByIds($productsIds);

            $totalPrice = Cart::getTotalPrice($products);
        }

        require_once(ROOT . '/views/cart/index.php');

        return true;
    }

    /**
     * Clear all cart
     */
    public function actionClear() {
        Cart::clear();
    }

    /**
     * Deletes product with specified id from cart
     * @param $id
     */
    public function actionDelete($id)
    {
        Cart::deleteProduct($id);

        header("Location: /cart");
    }


}
