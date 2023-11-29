<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function CategoryPage()
    {
        return view('pages.dashboard.category-page');
    }

    function CategoryCreate(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        dd($request->header('id'));
        $category->user_id = $request->header('id');
        $category->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Category Created Successfully'
        ]);
    }
    function CategoryUpdate(Request $request)
    {
        $categoryId = $request->input('category_id');
        $userId = $request->header('id');
        Category::where('user_id', $userId)->where('id', $categoryId)->update([
            'name' => $request->input('name')
        ]);
    }

    function CategoryDelete(Request $request)
    {
        $categoryId = $request->input('category_id');
        $userId = $request->header('id');
        Category::where('user_id', $userId)->where('id', $categoryId)->delete();
    }

    function CategoryList(Request $request)
    {
        $categoryId = $request->input('category_id');
        $userId = $request->header('id');
        dd($categoryId);
        return Category::where('user_id', $userId)->where('id', $categoryId)->get();
    }
}
