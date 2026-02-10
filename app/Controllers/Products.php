<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Products extends Controller
{
    public function form()
    {
        return view('product_form');
    }

    public function index()
    {
        return "
        <h2>This is the product list:</h2>
        <ul>
            <li>Ballpen</li>
            <li>Pencil</li>
            <li>Highlighter</li>
            <li>Whiteboard Marker</li>
        </ul>
        ";
    }

    public function details($id)
    {
        return "Product details for ID: " . $id;
    }

    public function save()
    {
        return "Product saved...";
    }
}
