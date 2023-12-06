<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    function ProductPage()
    {
        return view('pages.dashboard.product-page');
    }

    function productCreate(Request $request)
    {
        try {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|max:50',
            'name' => 'required|max:255',
            'price' => 'required|max:50',
            'unit' => 'required|max:50',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'image.mimes' => 'Please select a jpg, png, jpg, gif, or svg image',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->toArray()
            ]);
        }

        $user_id = $request->header('id');
        $image = $request->file('image');
        $img_ext = $image->getClientOriginalExtension();
        $image_name = time() . '.' . $img_ext; // Generate a unique name for the image
        
        $productData = [
            'user_id' => $user_id,
            'category_id' => $request->input('category_id'),
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'unit' => $request->input('unit'),
            'img_url' => $image_name
        ];
        
        DB::beginTransaction();

            $createProduct = Product::create($productData);

            if ($createProduct) {
                $image->move(public_path('images/product'), $image_name);
                DB::commit();

                return response()->json([
                    'status' => 200,
                    'message' => 'Product created successfully'
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 404,
                'message' => 'Product not created: ' . $e->getMessage()
            ]);
        }
    }

    function productUpdate(Request $request)
    {
        $productId = $request->input('product_id');
        $user_id = $request->header('id');
        $product = Product::where('id', $productId)->where('user_id', $user_id)->first();

        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required|max:50',
            'unit' => 'required|max:50',
            'category_id' => 'required|max:50',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'image.mimes' => 'Please select a jpg, png, jpg, gif, or svg image',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()
            ]);
        }

        $oldImageUrl = $request->input('file_path');

        $productData = [
            'user_id' => $user_id,
            'category_id' => $request->input('category_id'),
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'unit' => $request->input('unit'),
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $img_ext = $image->getClientOriginalExtension();
            $image_name = time() . '.' . $img_ext; // Generate a unique name for the image
            $productData['img_url'] = $image_name;

            $image->move(public_path('images/product'), $image_name);

            // Remove the old image file
            $oldFilePath = public_path('images/product') . '/' . $oldImageUrl;
            if (File::exists($oldFilePath)) {
                File::delete($oldFilePath);
            }
        }
        DB::beginTransaction();

        try {
            $product->update($productData);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Product updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 500,
                'message' => 'Product update failed: ' . $e->getMessage()
            ]);
        }
    }

    function productDelete(Request $request)
    {
        $productId = $request->input('product_id');
        $imgPath = $request->input('file_path');
        $userId = $request->header('id');
        $product = Product::where('id', $productId)
            ->where('user_id', $userId)
            ->first();

        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found'
            ]);
        }
        DB::beginTransaction();

        try {
            $filePath = public_path('images/product') . '/' . $imgPath;
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $product->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 500,
                'message' => 'Product delete failed: ' . $e->getMessage()
            ]);
        }
    }

    function productList(Request $request)
    {
        $userId = $request->header('id');
        $product = Product::where('user_id', $userId)->get();
        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found'
            ]);
        }
        return response()->json([
            'status' => 200,
            'product' => $product
        ]);
    }
    function productById(Request $request)
    {
        $productId = $request->input('product_id');
        $userId = $request->header('id');
        $product = Product::where('id', $productId)
            ->where('user_id', $userId)
            ->first();
        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found'
            ]);
        }
        return response()->json([
            'status' => 200,
            'product' => $product
        ]);
    }
}
