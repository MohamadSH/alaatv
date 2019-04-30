<?php

namespace App\Http\Controllers\Web;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request, Category $category)
    {
        $id     = $request->id;
        $result = $category->newQuery()
            ->active()
            ->descendantsOf($id)
            ->toTree();
        dd($result);
    }
}
