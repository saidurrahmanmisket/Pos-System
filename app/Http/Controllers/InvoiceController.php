<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    //page routes
    function InvoicePage()
    {
        return view('pages.dashboard.invoice-page');
    }
    function SalePage()
    {
        return view('pages.dashboard.sale-page');
    }


    //Api routes
    function invoiceCreate(Request $request)
    {
        try {
            $request->validate([
                'total' => 'required',
                'vat' => 'required',
                'discount' => 'required',
                'payable' => 'required',
                'customerId' => 'required',
                'products' => 'required'

            ]);
            $userID = $request->header('id');

            $total = $request->total;
            // $total = $request->total;
            $vat = $request->vat;
            $discount = $request->discount;
            $payable = $request->payable;
            $customerId = $request->customerId;
            // dd($request);
            DB::beginTransaction();
            $invoice = Invoice::create([
                'total' => $total,
                'discount' => $discount,
                'vat' => $vat,
                'payable' => $payable,
                'user_id' => $userID,
                'customer_id' => $customerId
            ]);

            $invoiceId = $invoice->id;
            $products = $request->products;


            $invoiceProducts = [];

            foreach ($products as $product) {
                $invoiceProducts[] = [
                    'invoice_id' => $invoiceId,
                    'product_id' => $product['product_id'],
                    'user_id' => $userID,
                    'qty' => $product['qty'],
                    'sale_price' => $product['sale_price']
                ];
            }
            InvoiceProduct::insert($invoiceProducts);


            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Invoice created successfully'
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 500,
                'message' => 'Somthing went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    function invoiceSelect(Request $request)
    {
        try {
            $userID = $request->header('id');
            $data = Invoice::where('user_id', $userID)
                ->with('customer')
                ->get();
            if (!$data) {
                return response()->json([
                    'status' => 404,
                    'message' => 'data not found'
                ]);
            }
            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }


    function invoiceDetails(Request $request)
    {
        try {
            $userID = $request->header('id');
            $customerId = $request->customer_id;
            $invoiceId = $request->invoice_id;

            $customer = Customer::where('user_id', $userID)
            ->select('id', 'name', 'email', 'created_at')
                ->where('id', $customerId)
                ->first();

            $invoice = Invoice::where('user_id', $userID)
                ->select('id', 'total', 'vat', 'discount', 'payable')
                ->where('id', $invoiceId)
                ->first();
            $invoiceProducts = InvoiceProduct::with(['product:id,name'])
                ->where('user_id', $userID)
                ->where('invoice_id', $invoiceId)
                ->select('id', 'product_id','sale_price', 'qty',)
                ->get();




            return response()->json([
                'status' => 200,
                'customer' => $customer,
                'invoice' => $invoice,
                'invoiceProducts' => $invoiceProducts,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Somthing Went wrong",
                'error' => $e->getMessage()
            ]);
        }
    }

    function invoiceList(Request $request)
    {
        try {
            $userID = $request->header('id');
            $invoice = Invoice::where('user_id', $userID)->get();
            if (!$invoice) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Invoice not found'
                ]);
            }
            return response()->json([
                'status' => 200,
                'data' => $invoice,
                'message' => 'Invoice list'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }
    function invoiceDelete(Request $request)
    {
        try {
            $userID = $request->header('id');
            $id = $request->input('id');
            $invoice = Invoice::where('user_id', $userID)->where('id', $id)->first();
            if (!$invoice) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Invoice not found'
                ]);
            }
            $invoice->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Invoice deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }


    //not implement , create for future use
    function invoiceUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $userID = $request->header('id');
            $total = $request->input('total');
            $vat = $request->input('vat');
            $discount = $request->input('discount');
            $payable = $request->input('payable');
            $customerId = $request->input('customer_id');
            $invoiceId = $request->input('invoice_id');

            $invoice = Invoice::where('user_id', $userID)
                ->where('id', $invoiceId)
                ->where('customer_id', $customerId)
                ->first();

            $invoice->update([
                'total' => $total,
                'vat' => $vat,
                'discount' => $discount,
                'payable' => $payable
            ]);
            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Invoice created successfully'
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 500,
                'error' => $e->getMessage()
            ]);
        }
    }
}
