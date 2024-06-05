# Symfony Microservice Example

### Microservice description
This code is a practice for develop Symfony based microservice. 
This came from this Youtube link tutorial > https://www.youtube.com/watch?v=pZv93AEJhS8

Code simulates and endpoint to apply promotion for given product, 
depending on voucher code, specific date or amount of products.

### Project tech stack

- Symfony version 7.0.7
- PHP version 8.3.7
- Composer 2.2.6
- Redis for cache
- MySQL Database 

### Project initialization

First of all, you must install composer project dependencies.
````
//-- Composer dependencies install
> composer install
````

For testing this project you must have docker installed 
on your computer to serve MySQL and Redis Caché containers. 

````
//-- Run MySql and Redis containers on background
> docker compose up -d
````

Launch symfony server on background

````
//-- Symfony start server
> symfony serve -d
````

### Table migrations

Run table migrations:

````
//-- Running migrations command
> symfony console doctrine:migrations:migrate
````

### Dummy data import

For dummy data testing you must execute this queries 

````
# PRODUCT POPULATION
INSERT INTO product (id, price) VALUES
    (1, 100),
    (2, 200);

# PROMOTION POPULATION
INSERT INTO promotion (id, name, type, adjustment, criteria) VALUES
    (1, 'Black Friday half price sale', 'date_range_multiplier', 0.5, '{\"to\": \"2022-11-28\", \"from\": \"2022-11-25\"}'),
    (2, 'Voucher OU812', 'fixed_price_voucher', 100, '{\"code\": \"OU812\"}'),
    (3, 'Buy one get one free', 'even_items_multiplier', 0.5, '{"minimun_quantity": 2}');

# PRODUCT_PROMOTION POPULATION
INSERT INTO product_promotion (id, product_id, promotion_id, valid_to) VALUES
    (1, 1, 1, '2022-11-28 00:00:00'),
    (2, 1, 2, NULL),
    (3, 1, 3, null);
````

### Application | Products Lowest Prices

For testing lowest prices endpoint you can use Postman.

````
//-- Lowest Price Endpoint
POST https://localhost:8000/products/1/lowest-price
````

````
//-- Body data
{
    "quantity": 1,
    "request_location": "UK",
    "voucher_code": "OU812",
    "request_date": "2022-11-29",
    "product_id": 1
}
````

You can change product quantity, voucher code and request date to check 3 different promotions.



### Application | Tests

Tests has been created for unit testing. 

````
//-- Application tests
> vendor/bin/phpunit tests/

````

### Aditional notes
If you have any doubts, please contact me. Thank you!
