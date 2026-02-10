<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Hello extends Controller
{

    protected $autoRoute = true;

    public function index()
    {
        return "Hello, World!";
    }

    public function greet($name = "Guest")
    {
        return "Hello, " . $name;
    }
}
