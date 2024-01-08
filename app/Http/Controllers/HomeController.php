<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showHome(){
        $products = Product::All();
        return response()->json($products);
    }
    public function detail($id){
        $product = Product::find($id);
        return response()->json([
            "product" => $product
        ]);
    }
}

