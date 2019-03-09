<?php 
class Helper {

    function getCartObject($products, $id) {
        $cart = new stdClass();
        $cart->type = "Cart";
        $cart->id = $id;
        $cart->items = $products;
        return $cart;
    }
}
?>