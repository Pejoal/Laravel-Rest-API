<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticControllor extends Controller
{
  // php artisan make:controller StaticControllor

  public function index()
  {
    // return view('welcome');
    return view('index');
  }

  public function about()
  {
    return view('about');
  }

  // /store?style=men
  public function store()
  {
    $urlParams = request('style');
    if (!isset($urlParams)) {
      $urlParams = "All";
    } else {
      // prevent scripts
      $urlParams = strip_tags($urlParams);
    }
    return "this page is viewing <span style='color: red'>" . $urlParams . "</span>"; // men
    // return view('more');
  }

  public function product($category = null, $item = null) {
    if (isset($category)) {
        if (isset($item)) {
            // http://127.0.0.1:8000/product/any/go/ => Category: any, Item: go
            return "<h1>Category: $category, Item: $item</h1>";
        }
        return "<h1>Category: $category</h1>";
    }
    // return "<h1>Hello</h1>";
    return view("product");
}

  public function go()
  {
    return view('go');
  }
  
}
