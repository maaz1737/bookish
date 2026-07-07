<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryCatalogController extends Controller
{
    public function index()
    {
        return view('storefront.shop-by-category'); 
    }
}
