<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function index()
    {
        echo "<pre>";

        echo "ENV:\n";
        var_dump($_ENV);

        echo "\nSERVER:\n";
        var_dump($_SERVER['database.default.hostname'] ?? null);

        echo "\nGETENV:\n";
        var_dump(getenv('database.default.hostname'));

        echo "</pre>";
    }
}