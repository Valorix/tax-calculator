# tax-calculator

1) Installing the project
-------------------------

    composer install
    
It suppose you have [Composer][1] installed

2) Use
-------------------------------------

    php app.php 75000000
   
Where 75000000 is your income

Result :

    $ php app.php 75000000
    Tax is 6250000
    
3) Tests
-------------------------------------
    ./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/
    
Enjoy !

[1]:  https://getcomposer.org/