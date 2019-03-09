# shoppingcart

For running the app execute:

docker-compose up -d

Then import the database:

docker exec -i "mysql-container-name" mysql -uroot -prootpassword Shoppingcart_2019-03-09.sql

The app runs then on:

http://localhost/

The following queries are possible:

### ?method=cacheall

this is a helper method for caching everything

### ?method=cacheinvalidate 

this is a helper method for deleting cache

### ?method=checkout&customer=1

checks out the current cart of given customer

### ?method=put&customer=1&product=3

the product is add to current cart of given customer

### ?method=list&customer=1&cart=open

only outputs new products from current cart of given customer

### ?method=list&customer=1

outputs all new products from all carts of given customer
