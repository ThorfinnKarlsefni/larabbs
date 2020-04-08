<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Transformers\CategoryTransformer;

class CategoriesController extends Controller
{
    public function index(Category $category)
    {
        return $this->response->Collection($category::all(),new CategoryTransformer());
    }
}