<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function ProductPage()
    {
        return view('pages.dashboard.product-page');
    }

    function productCreate(Request $request)
    {
        $user_id = $request->header('id');
        $image = $request->file('image');
        //generate a unique name for img
        $img_ext = $image->getClientOriginalExtension();
        $image_name = time() . '.' . $img_ext;
        //validation
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'unit' => 'required',
            'category_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $createProduct = Product::create([
            'user_id' => $user_id,
            'category_id' => $request->input('category_id'),
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'unit' => $request->input('unit'),
            'img_url' => $image_name
        ]);
        if ($createProduct) {
            //store img after store product data
            $image->move(public_path('images/product'), $image_name);
            return response()->json([
                'status' => 200,
                'message' => 'Product created successfully'
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => 'Product not created'
        ]);
    }


    function productUpdate(Request $request)
    {
    }
    function productDelete(Request $request)
    {
    }
    function productList(Request $request)
    {
    }
    function productById(Request $request)
    {
    }
}
