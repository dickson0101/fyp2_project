
<?php
 
use Illuminate\Support\Facades\Route;
 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 
Route::get('/', function () {
    return view('welcome');
});



Route::post('/checkout', [App\Http\Controllers\PaymentController::class, 'paymentPost'])->name('payment.post');




Route::get('/about-us', function () {return view('aboutUs');})->name('aboutUs');

Route::get('/nursePage', function () {return view('nursePage');})->name('nursePage');

Route::get('/nursePage2', [App\Http\Controllers\AppointmentController::class, 'view4'])->name('nursePage2');

Route::get('/feedback',function(){ return  view('feedback');});

Route::post('/feedback',[App\Http\Controllers\feedbackController::class,'feedback'])->name('feedback');
 
Route::get('/addProduct',function(){ return  view('/addProduct');});
 
Route::post('/addProduct/store',[App\Http\Controllers\ProductController::class,'add'])->name('addProduct');
 
Route::get('/showProduct',[App\Http\Controllers\MedicationController::class,'view'])->name('showProduct');

Route::get('/addMedication', function(){ return view('addMedication');});

Route::post('/addMedication/store', [App\Http\Controllers\MedicationController::class, 'add'])->name('addMedication');

Route::get('/addInventory', [App\Http\Controllers\MedicationController::class, 'view'])->name('addInventory');

Route::get('/appointment', [App\Http\Controllers\AppointmentController::class, 'add'])->name('appointment');

Route::get('/checkAppointment', [App\Http\Controllers\AppointmentController::class, 'view2'])->name('checkAppointment');

Route::get('/successAppointment', [App\Http\Controllers\AppointmentController::class, 'view3'])->name('successAppointment');

Route::post('/productDetail/{id}', [App\Http\Controllers\MedicationController::class, 'productDetail'])->name('productDetail');

Route::get('/editProduct/{id}',[App\Http\Controllers\MedicationController::class,'edit'])->name('editProduct');
 
Route::post('/updateProduct',[App\Http\Controllers\MedicationController::class,'update'])->name('updateProduct');

Route::get('/deleteProduct/{id}', [App\Http\Controllers\MedicationController::class,'delete'])->name('deleteProduct');
 
Route::post('/addCart',[App\Http\Controllers\CartController::class,'addCart'])->name('addCart');

Route::get('/payment',[App\Http\Controllers\StripeController::class,'index'])->name('payment');

Route::post('/checkout',[App\Http\Controllers\StripeController::class,'checkout'])->name('checkout');

Route::get('/success',[App\Http\Controllers\StripeController::class,'success'])->name('success');

Route::post('/deleteFavorites', [App\Http\Controllers\CartController::class, 'deleteFavorites'])->name('deleteFavorites');

Route::post('/searchProduct', [App\Http\Controllers\ProductController::class, 'search'])->name('searchProduct');
 
Auth::routes();
 
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


