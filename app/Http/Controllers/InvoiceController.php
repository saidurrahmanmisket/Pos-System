<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            $userID = $request->header('id');
            $total = $request->input('total');
            $vat = $request->input('vat');
            $discount = $request->input('discount');
            $payable = $request->input('payable');
            $customerId = $request->input('customer_id');

            $invoice = Invoice::create([
                'user_id' => $userID,
                'total' => $total,
                'vat' => $vat,
                'discount' => $discount,
                'payable' => $payable,
                'customer_id' => $customerId
            ]);

            $invoiceId = $invoice->id;
            $products = $request->input('products');

            // foreach ($products as $product) {
            //     InvoiceProduct::create([
            //         'invoice_id' => $invoiceId,
            //         'product_id' => $product['product_id'],
            //         'qty' => $product['qty'],
            //         'user_id' => $userID,
            //         'sale_price' => $product['sale_price']
            //     ]);
            // }

            $invoiceProducts = [];

            foreach ($products as $product) {
                $invoiceProducts[] = [
                    'invoice_id' => $invoiceId,
                    'product_id' => $product['product_id'],
                    'qty' => $product['qty'],
                    'user_id' => $userID,
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
