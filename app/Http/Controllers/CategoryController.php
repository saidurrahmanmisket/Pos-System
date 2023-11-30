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
        // dd($request->header('id'));
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
        return response()->json([
            'status' => 'success',
            'message' => 'Category Updated Successfully'
        ]);
    }

    function CategoryDelete(Request $request)
    {
        $categoryId = $request->input('category_id');
        $userId = $request->header('id');
        $delete = Category::where('user_id', $userId)->where('id', $categoryId)->delete();
        if ($delete) {
            return response()->json([
                'status' => 'success',
                'message' => 'Category Deleted Successfully'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Category Not Deleted'
            ]);
        }
    }

    function CategoryList(Request $request)
    {
        // $categoryId = $request->input('category_id');
        $userId = $request->header('id');
        $categoryData = Category::where('user_id', $userId)->get();
        if ($categoryData) {
            return response()->json([
                'status' => 'success',
                'data' => $categoryData
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Category Not Found'
        ]);
    }
}
