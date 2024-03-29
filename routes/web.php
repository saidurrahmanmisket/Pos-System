<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





// Route::get('/', function () {
//     return view('welcome'); //for features implement
// });


// Api Routes Start from here ===========================================================================================================


//user route
Route::post('/user-registration', [UserController::class, 'userRegistration']);
Route::post('/user-login', [UserController::class, 'userLogin']);
Route::post('/send-otp', [UserController::class, 'userSentOTP']);
Route::post('/verify-otp', [UserController::class, 'userVerifyOTP'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/rest-password', [UserController::class, 'restPassword'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/user-profile', [UserController::class, 'userProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/user-update', [UserController::class, 'userUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/logout', [UserController::class, 'userLogOut'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/user-name', [UserController::class, 'userName'])->middleware([TokenVerificationMiddleware::class]);


//category route
Route::post('/category-create', [CategoryController::class, 'CategoryCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/category-update', [CategoryController::class, 'categoryUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/category-delete', [CategoryController::class, 'categoryDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/category-list', [CategoryController::class, 'categoryList'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/category-by-id', [CategoryController::class, 'categoryById'])->middleware([TokenVerificationMiddleware::class]);

//customer route
Route::post('/customer-create', [CustomerController::class, 'customerCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customer-update', [CustomerController::class, 'customerUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customer-delete', [CustomerController::class, 'customerDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/customer-list', [CustomerController::class, 'customerList'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/customer-by-id', [CustomerController::class, 'customerById'])->middleware([TokenVerificationMiddleware::class]);


//product route
Route::post('/product-create', [ProductController::class, 'productCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/product-update', [ProductController::class, 'productUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/product-delete', [ProductController::class, 'productDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/product-list', [ProductController::class, 'productList'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/product-by-id', [ProductController::class, 'productById'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/ck-product-qty-by-id', [ProductController::class, 'ckProductQtyById'])->middleware([TokenVerificationMiddleware::class]);


//invoice route
Route::post('/invoice-create', [InvoiceController::class, 'invoiceCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/invoice-delete', [InvoiceController::class, 'invoiceDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/invoice-select', [InvoiceController::class, 'invoiceSelect'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/invoice-details', [InvoiceController::class, 'invoiceDetails'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/invoice-list', [InvoiceController::class, 'invoiceList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/invoice-update', [InvoiceController::class, 'invoiceUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/invoice-by-id', [InvoiceController::class, 'invoiceById'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/invoice-download', [ReportController::class, 'salesReport'])->middleware([TokenVerificationMiddleware::class]);


//Report route
Route::get('/sales-report/{fromDate}/{toDate}/{download}', [ReportController::class, 'salesReport'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/sales-report/{fromDate}/{toDate}/', [ReportController::class, 'salesReport'])->middleware([TokenVerificationMiddleware::class]);
// Route::get('/sales-report-page',[ReportController::class, 'salesReportPage'])->middleware([TokenVerificationMiddleware::class]);

///summary
Route::get('/summary', [ReportController::class, 'summary'])->middleware([TokenVerificationMiddleware::class]);

// Api Routes End here ===========================================================================================================







// Page Routes start from here=====================================================================================================================

// Route::get('/', [HomeController::class, 'HomePage']);
Route::get('/userLogin', [UserController::class, 'LoginPage']);
Route::get('/userRegistration', [UserController::class, 'RegistrationPage']);
Route::get('/sendOtp', [UserController::class, 'SendOtpPage']);
Route::get('/verifyOtp', [UserController::class, 'VerifyOTPPage'])->middleware([TokenVerificationMiddleware::class]);



Route::get('/', [DashboardController::class, 'DashboardPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/resetPassword', [UserController::class, 'ResetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/categoryPage', [CategoryController::class, 'CategoryPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/dashboard', [DashboardController::class, 'DashboardPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/userProfile', [UserController::class, 'ProfilePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/customerPage', [CustomerController::class, 'CustomerPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/productPage', [ProductController::class, 'ProductPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/invoicePage', [InvoiceController::class, 'InvoicePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/salePage', [InvoiceController::class, 'SalePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/reportPage', [ReportController::class, 'ReportPage'])->middleware([TokenVerificationMiddleware::class]);



// Page Routes end here=====================================================================================================================