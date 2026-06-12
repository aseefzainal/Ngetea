<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class MenuController extends Controller
{
    public function index()
    {
        // Get active categories with available products and variations
        $categories = Category::with(['products' => function($query) {
            $query->where('is_available', true)->with(['variations' => function($q) {
                $q->where('is_available', true);
            }]);
        }])->where('is_active', true)->get();

        return view('menu.index', compact('categories'));
    }
}
