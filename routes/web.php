
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

//account
Route::get('/', function () {
    return view('welcome');
});

Route::get('homePaient', function () {
    return view('homePaient');
})->middleware(['auth', 'verified', 'rolemanager:patient'])->name('homePaient');

Route::get('doctor/dashboard', function () {
    return view('homedoctor');
})->middleware(['auth', 'verified', 'rolemanager:doctor'])->name('doctor');

Route::get('nurse/dashboard', function () {
    return view('nursePage');
})->middleware(['auth', 'verified', 'rolemanager:nurse'])->name('nurse');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//account edit

Route::get('/account', function () {return view('account');})->name('account');

Route::put('/account/update', [AccountController::class, 'update'])->name('account.update');

//home

Route::get('/nursePage', [App\Http\Controllers\HomeController::class, 'viewNurse'])->name('nursePage');

Route::get('/homePatient',[App\Http\Controllers\HomeController::class, 'viewPatient'])->name('homePatient');

Route::get('/homeDoctor',[App\Http\Controllers\HomeController::class, 'viewDoctor'])->name('homeDoctor');

//other

Route::get('/aboutUs', function () {return view('aboutUs');})->name('aboutUs');

Route::get('/F&Q', function () {return view('F&Q');})->name('F&Q');

Route::get('/contactUs',function(){ return  view('contactUs');});

Route::post('/contactUs',[App\Http\Controllers\ContactUsController::class,'contactUs'])->name('contactUs');

Route::get('/feedback',function(){ return view('feedback');});

Route::post('/feedback',[App\Http\Controllers\feedbackController::class,'feedback'])->name('feedback');

//add event

Route::get('/pdf.index', [App\Http\Controllers\PDFController::class, 'index'])->name('pdf.index');

Route::post('/generate-pdf', [App\Http\Controllers\PDFController::class, 'generatePDFAndZip'])->name('Patient_Report.pdf');

//inventory
 
Route::get('/showProduct',[App\Http\Controllers\InventoryController::class,'view'])->name('showProduct');

Route::get('/addMedication', function(){ return view('addMedication');});

Route::post('/addMedication', [App\Http\Controllers\InventoryController::class, 'add'])->name('addMedication');

Route::get('/editProduct/{id}',[App\Http\Controllers\InventoryController::class,'edit'])->name('editProduct');
 
Route::post('/updateProduct',[App\Http\Controllers\InventoryController::class,'update'])->name('updateProduct');

Route::get('/deleteProduct/{id}', [App\Http\Controllers\InventoryController::class,'delete'])->name('deleteProduct');

//medication

Route::get('/medications', [App\Http\Controllers\MedicationController::class, 'index'])->name('medications.list');

Route::get('/medications/create', [App\Http\Controllers\MedicationController::class, 'create'])->name('medications.create');

Route::post('/medications', [App\Http\Controllers\MedicationController::class, 'store'])->name('medications.store');

Route::delete('/medications/{id}', [App\Http\Controllers\MedicationController::class, 'destroy'])->name('medications.destroy');

Route::post('/update-medication-quantities', [App\Http\Controllers\MedicationController::class, 'updateMedicationQuantities'])->name('updateMedicationQuantities');
//doctor

Route::get('/doctorPage', [App\Http\Controllers\DoctorController::class, 'view'])->name('doctorPage');

Route::get('/doctorAdd', function(){ return view('doctorAdd');});

Route::post('/doctorAdd', [App\Http\Controllers\DoctorController::class, 'add'])->name('doctorAdd');

Route::get('/doctorEdit/{id}',[App\Http\Controllers\DoctorController::class,'edit'])->name('doctorEdit');

Route::post('/doctor/update/{id}', [App\Http\Controllers\DoctorController::class, 'update'])->name('doctorUpdate');

Route::post('/searchDoctor', [App\Http\Controllers\DoctorController::class, 'search'])->name('searchDoctor');

Route::get('/deleteDoctor/{id}', [App\Http\Controllers\DoctorController::class,'delete'])->name('deleteDoctor');

//appointment

Route::get('/appointment', [App\Http\Controllers\AppointmentController::class, 'add'])->name('appointment');

Route::post('/appointment', [App\Http\Controllers\AppointmentController::class, 'add'])->name('appointment.store');

Route::get('/successAppointment', [App\Http\Controllers\AppointmentController::class, 'view3'])->name('successAppointment');

Route::get('/get-doctor-times/{doctorId}', [App\Http\Controllers\AppointmentController::class, 'getDoctorUnavailableTimes']);

//payment
 
Route::post('/checkout', [App\Http\Controllers\PaymentController::class, 'paymentPost'])->name('payment.post');

Route::get('/payment',[App\Http\Controllers\StripeController::class,'index'])->name('payment');

Route::post('/checkout',[App\Http\Controllers\StripeController::class,'checkout'])->name('checkout');

Route::get('/success',[App\Http\Controllers\StripeController::class,'success'])->name('success');

//video

Route::get('/videopatient', function () { return view('videopatient'); })->name('videopatient');
Route::get('/videodoctor', function () { return view('videodoctor'); })->name('videodoctor');
Route::get('/videoindex', function () { return view('videoindex'); })->name('videoindex');
Route::get('/index', function () { return view('index'); })->name('index');
Route::get('/consultation', function () { return view('consultation'); })->name('consultation');

//scheduler

Route::get('/scheduler', [App\Http\Controllers\SchedulerController::class, 'index'])->name('scheduler');

//laravel

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


