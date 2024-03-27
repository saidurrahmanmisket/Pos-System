<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{
    function ReportPage()
    {
        return view('pages.dashboard.report-page');
    }
    function salesReport(Request $request)
    {
        try {

            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));
            $id = $request->header('id');

            $invoice = Invoice::with(['customer:id,name,mobile,email'])
                ->where('user_id', '=', $id)
                ->select('total', 'discount', 'vat', 'payable', 'customer_id', 'created_at')
                ->whereDate('created_at', '>=',  $fromDate)
                ->whereDate('created_at', '<=',  $toDate)
                ->get();

            $summary =  Invoice::where('user_id', '=', $id)
                ->select(
                    DB::raw('SUM(total) as total_sell'),
                    DB::raw('SUM(discount) as total_discount'),
                    DB::raw('SUM(vat) as total_vat'),
                    DB::raw('SUM(payable) as total_payable')
                )
                ->whereDate('created_at', '>=',  $fromDate)
                ->whereDate('created_at', '<=',  $toDate)
                ->get();
            $fromDate = $fromDate;
            $toDate = $toDate;
            $data = [
                'fromDate' => $fromDate,
                'toDate' => $toDate,
                'invoice' => $invoice,
                'summary' => $summary,
            ];

            if ($data['invoice']->isEmpty()) {
                return response()->json([
                    'status' => 404,
                    'message' => 'data not found'
                ]);
            }

            // return view('report.salesReport', compact('data'));
            if ($request->download == 'pdf') {
                //generate pdf and download
                $pdf = Pdf::loadView('report.salesReport', $data);
                return $pdf->download('sales-report.pdf');
            }
            return response()->json([
                'status' => 200,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    function summary(Request $request)
    {
        try {
            $user_id = $request->header('id');
            $product = Product::where('user_id', '=', $user_id)->count();
            $category = Category::where('user_id', '=', $user_id)->count();
            $customer = Customer::where('user_id', '=', $user_id)->count();
            $invoice = Invoice::where('user_id', '=', $user_id)->count();
            $total = Invoice::where('user_id', '=', $user_id)->select(
                DB::raw('SUM(CONVERT(total, DECIMAL(10,2))) as total_sell'),
                DB::raw('SUM(CONVERT(discount, DECIMAL(10,2))) as total_discount'),
                DB::raw('SUM(CONVERT(vat, DECIMAL(10,2))) as total_vat'),
                DB::raw('SUM(CONVERT(payable, DECIMAL(10,2))) as total_payable')
            )
                ->get();

            $getThisYear = Date::now()->year;
            $sellByMonthThisYear = Invoice::where('user_id', '=', $user_id)
                ->whereBetween('created_at', ["{$getThisYear}-01-01", "{$getThisYear}-12-31"])
                ->select(
                    DB::raw('SUM(payable) as total_collection'), 
                    DB::raw('MONTH(created_at) as month_number'), 
                    DB::raw('MONTHNAME(created_at) as month') 
                )
                ->groupBy('month_number') 
                ->groupBy('month') 
                ->orderBy('month_number', 'asc') 
                ->get();


            $topSellingProduct = InvoiceProduct::with(['product:id,name'])->where('user_id', '=', $user_id)
                ->select('product_id', DB::raw('SUM(qty) as total_qty'))
                ->groupBy('product_id')
                ->orderBy('total_qty', 'desc')
                ->limit(10)
                ->get();

            $data = [
                'product' => $product,
                'category' => $category,
                'customer' => $customer,
                'invoice' => $invoice,
                'total' => $total,
                'topSellingProduct' => $topSellingProduct,
                'sellByMonthThisYear' => $sellByMonthThisYear
            ];
            return response()->json([
                'status' => 200,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
