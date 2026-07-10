<?php

echo "<pre>";

echo "MYSQLHOST = ";
var_dump(getenv('MYSQLHOST'));

echo "MYSQLDATABASE = ";
var_dump(getenv('MYSQLDATABASE'));

echo "MYSQLUSER = ";
var_dump(getenv('MYSQLUSER'));

echo "PORT = ";
var_dump(getenv('PORT'));

echo "\n\n_SERVER:\n";
print_r(array_intersect_key($_SERVER, array_flip([
    'MYSQLHOST',
    'MYSQLDATABASE',
    'MYSQLUSER',
    'MYSQLPASSWORD',
    'MYSQLPORT',
    'PORT'
])));