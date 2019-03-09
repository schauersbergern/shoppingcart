<?php
session_start();
require_once('Database.php');
require_once('Objectizer.php');
require_once('Helper.php');

$method = $_GET["method"];
$customer = $_GET["customer"];
$product = $_GET["product"];
$cart = $_GET["cart"];
$sortby = $_GET["sortby"];

if ($sortby =="") {
    $sortby = null;
}

//helper method for caching everything
if ($method == "cacheall") {
    $db = new Database();
    $db->updateCache(session_id());
}

//helper method for deleting cache
if ($method == "cacheinvalidate") {
    $db = new Database();
    $db->updateCache("new");
}

//eg ?method=checkout&customer=1
//checkout current cart
if ($method == "checkout" && $customer != "") {
    $db = new Database();
    $db->checkoutCurrentCart($customer);
}

//eg ?method=put&customer=1&product=3
// here we add products
if ($method == "put" && $customer != "" && $product != "" && $cart_id == "") {
    $db = new Database();
    $db->addToCart($product, $customer);
}

//eg ?method=list&customer=1&cart=open
//here we only show new products from current cart
if ($method == "list" && $customer != "" && $cart == "open") {
    $db = new Database();
    $result = $db->getProductList($customer, null, $sortby);

    $objectizer = new Objectizer();
    $products = $objectizer->getValueArray($result['items']);

    $helper = new Helper();
    $basket = $helper->getCartObject($products, $result['id']);

    $myJSON = json_encode($basket);

    header('Content-Type: application/json');
    echo $myJSON;

    return;
} else if ($method == "list" && $customer != "") {
//eg ?method=list&customer=1
//here we show all new Products from all Carts
    $db = new Database();
    $result = $db->getAllCarts($customer, $cart);

    $count =  count($result);

    $all_carts[$count]; 
    for ($i = 0; $i < $count; $i++) {

        $cart = $result[$i];
        $result = $db->getProductList($customer, $cart, $sortby);

        $objectizer = new Objectizer();
        $products = $objectizer->getValueArray($result['items']);

        $helper = new Helper();
        $basket = $helper->getCartObject($products, $result['id']);
        $all_carts[$i] = $basket;
    }

    $myJSON = json_encode($all_carts);

    header('Content-Type: application/json');
    echo $myJSON;

    return;

}


?>