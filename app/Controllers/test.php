<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function index()
    {
        echo "<pre>";

        var_dump(env('database.default.hostname'));
        var_dump(env('database.default.database'));
        var_dump(env('database.default.username'));
        var_dump(env('database.default.password'));
        var_dump(env('database.default.DBDriver'));
        var_dump(env('database.default.port'));

        echo "</pre>";
    }
}