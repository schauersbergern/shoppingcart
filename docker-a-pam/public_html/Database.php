<?php
class Database {

    private $host = 'mysql';
    private $user = 'root';
    private $pass = 'rootpassword';
    private $database = 'Shoppingcart';

    function checkoutCurrentCart($user_id) {
        $conn = $this->connect();

        $sql = "UPDATE Carts set status = 'sold' where customer = $user_id;";
        $conn->query($sql);
        $conn->close();
    }

    function updateCache($value) {
        $conn = $this->connect();

        $sql = "UPDATE Sales set etag = '$value';";
        $conn->query($sql);
        $conn->close();
    }

    function getProductList($customer, $cart, $sort) {
        $conn = $this->connect();

        $cart_id = $cart;
        if ($cart == null) {
            $cart_id = $this->getOpenCart($conn, $customer);
        }

        $sortby = "";

        if ($sort == 'weight') {
            $sortby = "ORDER BY p.weight DESC";
        }else if ($sort == 'calories') {
            $sortby = "ORDER BY p.calories DESC";
        } else if ($sort == 'price') {
            $sortby = "ORDER BY p.price DESC";
        }

        $sql = "SELECT 
        p.id, s.amount, p.name, p.weight, p.price, p.calories
      FROM 
        Sales s,
        Products p  
      WHERE
        s.product = p.id AND
        s.etag = 'new' AND
        s.cart = $cart_id"." ".$sortby;

        $result['id'] = $cart_id;
        $result['items'] = $conn->query($sql);

        //@TODO: add etag only for fetched ids instead of all items from cart
        $etag = session_id();
        //mark as 'cached'
        $update = "UPDATE Sales set etag = '$etag' where cart = $cart_id";
        $conn->query($update);
        $conn->close();
        return $result;
    }

    function addToCart($product, $customer) {
        $conn = $this->connect();

        //check if actual cart is present
        $cart_id = $this->getOpenCart($conn, $customer);

        //add new open cart because no open cart is present
        if ($cart_id == 0) {
            $cart_id = $this->addOpenCart($conn, $customer);
        }
        
        $etag = "new";
        $this->addProductRow($cart_id, $product, $customer, $etag, $conn);   
        $conn->close();
    }

    function getOpenCart($conn, $customer) {
        $sql = "SELECT id from Carts where customer = $customer AND status = 'open'";
        $result = $conn->query($sql);

        $id = $this->sqlGetResultValue($result, "id");

        if (is_numeric($id)) {
            return $id;
        } else {
            return 0;
        }
    }

    function addProductRow($id, $product, $customer, $etag, $conn) {

        $sql = "SELECT amount from Sales where cart = $id AND product = $product";
        $query = $conn->query($sql);

        $amount = $this->sqlGetResultValue($query, "amount");

        echo $amount;

        if (is_numeric($amount)) {
            $amount++;
            $sql = "UPDATE Sales SET amount = $amount, etag = '$etag' where cart = $id and product = $product";
            $result = $conn->query($sql);
        } else {
            $amount = 1;
            $sql = "insert into Sales (cart, product, amount, etag) values($id, $product, $amount, '$etag')";
            $result = $conn->query($sql);
        }
        
    }

    function sqlGetResultValue($qeryResult, $key) {
        $row = $qeryResult->fetch_assoc();
        $value = $row[$key];
        return $value;
    }

    function getAllCarts($user_id) {

        $conn = $this->connect();

        $sql = "SELECT id FROM Carts where customer = $user_id";
        $result = $conn->query($sql);

        $array = $this->getArray($result, 'id');
        return $array;
        $conn->close();

    }

    function getArray($db_result, $key) {
        $array[$db_result->num_rows];
        if ($db_result->num_rows > 0) {
            $i = 0;
            while($row = $db_result->fetch_assoc()) {
                $array[$i] = $row[$key];
                $i++;
            }
        } 
        return $array;
    }

    function addOpenCart($db_connection, $customer) {
        $sql = "insert into Carts (customer, status) values($customer, 'open')";
        $result = $db_connection->query($sql);
        
        if ($result == true) {
            //return id
            $sql = "SELECT id FROM Carts WHERE customer = $customer AND status = 'open'";
            $query = $db_connection->query($sql);

            $id = $this->sqlGetResultValue($query, 'id');

            if (is_numeric($id) ) {
                return $id;
            } else {
                return 0;
            }
        } else {
            die("could not write database");
        }
        
    }
    

    function getProducts() {
        $conn = $this->connect();

        $sql = "SELECT id, name, weight, price, calories FROM Products";
        $result = $conn->query($sql);

        $conn->close();
        return $result;
    } 

    function connect() {
        $conn = new mysqli($this->host, $this->user, $this->pass, $this->database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        return $conn;
    }
} 
?>