<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    function CustomerPage()
    {
        return view('pages.dashboard.customer-page');
    }


    function customerCreate(Request $request)
    {
        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->mobile = $request->input('mobile');
        $customer->user_id = $request->header('id');
        $customer->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Customer Created Successfully'
        ]);
    }


    function customerUpdate(Request $request)
    {

        $customerId = $request->input('customer_id');
        $userId = $request->header('id');
        $update = Customer::where('user_id', $userId)->where('id', $customerId)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile')
        ]);
        if ($update) {
            return response()->json([
                'status' => 'success',
                'message' => 'Customer Updated Successfully'
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Customer Not Updated'
        ]);
    }


    function customerDelete(Request $request)
    {

        $customerId = $request->input('customer_id');
        $userId = $request->header('id');
        $delete = Customer::where('user_id', $userId)->where('id', $customerId)->delete();
        if ($delete) {
            return response()->json([
                'status' => 'success',
                'message' => 'Customer Deleted Successfully'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Customer Not Deleted'
            ]);
        }
    }


    function customerList(Request $request)
    {
        $userId = $request->header('id');
        $customerData = Customer::where('user_id', $userId)->get();
        if ($customerData) {
            return response()->json([
                'status' => 'success',
                'data' => $customerData
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Customer Not Found'
        ]);
    }


    function customerById(Request $request)
    {

        $customerId = $request->input('customer_id');
        $userId = $request->header('id');
        $customerData = Customer::where('user_id', $userId)->where('id', $customerId)->first();
        if ($customerData) {
            return response()->json([
                'status' => 'success',
                'data' => $customerData
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Customer Not Found'
        ]);
    }
}
