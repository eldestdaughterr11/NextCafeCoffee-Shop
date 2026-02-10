<?php

namespace App\Controllers;

class Blog extends BaseController
{
    public function view($id)
    {
        return "You are viewing blog post with ID: " . $id;
    }
    public function blogList()
    {
        return view('blog_list');
    }
}
