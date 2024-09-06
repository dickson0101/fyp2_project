
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
//homepage


Route::post('/logout2', [App\Http\Controllers\CustomLogoutController::class, 'logout'])->name('logout2');


Route::get('/homePage', function () {return view('homePage');})->name('homePage');

//account
Route::get('/', function () {
    return view('welcome');
});

Route::get('homePatient', [App\Http\Controllers\AppointmentController::class, 'index'])
    ->middleware(['auth', 'verified', 'rolemanager:homePatient'])
    ->name('homePatient');

Route::get('homeDoctor', [App\Http\Controllers\AppointmentController::class, 'showDoctorDashboard'])
    ->middleware(['auth', 'verified', 'rolemanager:doctor'])
    ->name('homeDoctor');
    

Route::get('nursePage', [App\Http\Controllers\AppointmentController::class, 'showNurseDashboard'])
    ->middleware(['auth', 'verified', 'rolemanager:nurse'])
    ->name('nursePage');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//account edit

Route::get('/account', function () {return view('account');})->name('account');

Route::get('/doctorAccount', function () {return view('doctorAccount');})->name('doctorAccount');

Route::put('/account/update', [App\Http\Controllers\accountController::class, 'update'])->name('account.update');

Route::delete('/account', [App\Http\Controllers\accountController::class, 'destroy'])->name('account.destroy');

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

Route::get('/report', [App\Http\Controllers\PDFController::class, 'viewReports'])->name('patient.view.reports');

Route::get('/select-patient', [App\Http\Controllers\PDFController::class, 'selectPatient'])->name('select.patient');

Route::post('/store-selected-patient', [App\Http\Controllers\PDFController::class, 'storeSelectedPatient'])->name('store.selected.patient');

Route::get('/edit-report/{reportId}', [App\Http\Controllers\PDFController::class, 'editZip'])->name('Patient_Report.edit');

Route::put('/update-report/{reportId}', [App\Http\Controllers\PDFController::class, 'updateZip'])->name('Patient_Report.update');

Route::get('/reportView', [App\Http\Controllers\PDFController::class, 'viewReport'])->name('reportView');

Route::get('/nurseReport', [App\Http\Controllers\PDFController::class, 'nurseReport'])->name('nurseReport');


Route::delete('/report-files/{id}', [App\Http\Controllers\PDFController::class, 'destroy'])->name('reportFiles.destroy');

Route::get('/download-report/{id}', [App\Http\Controllers\PDFController::class, 'downloadReport'])->name('downloadReport');


Route::get('/doctorList', [App\Http\Controllers\MedicationController::class, 'index2'])->name('doctorList');

Route::get('/medications/{id}/edit', [App\Http\Controllers\MedicationController::class, 'edit'])->name('medications.edit');

Route::put('/medications/{id}', [App\Http\Controllers\MedicationController::class, 'update'])->name('medications.update');

Route::get('/nurseList', [App\Http\Controllers\MedicationController::class, 'list'])->name('nurseList');

Route::delete('/medications/{id}', [App\Http\Controllers\MedicationController::class, 'destroy2'])->name('medications.destroy2');



//inventory
 
Route::get('/showProduct',[App\Http\Controllers\InventoryController::class,'view'])->name('showProduct');

Route::get('/addMedication', function(){ return view('addMedication');});

Route::post('/addMedication', [App\Http\Controllers\InventoryController::class, 'add'])->name('addMedication');

Route::get('/editProduct/{id}',[App\Http\Controllers\InventoryController::class,'edit'])->name('editProduct');
 
Route::post('/updateProduct',[App\Http\Controllers\InventoryController::class,'update'])->name('updateProduct');

Route::get('/deleteProduct/{id}', [App\Http\Controllers\InventoryController::class,'delete'])->name('deleteProduct');

Route::get('/search', [App\Http\Controllers\InventoryController::class, 'search'])->name('searchMedication');


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

Route::get('/search', [App\Http\Controllers\DoctorController::class, 'search'])->name('searchDoctor');

Route::get('/deleteDoctor/{id}', [App\Http\Controllers\DoctorController::class,'delete'])->name('deleteDoctor');

Route::get('/doctors/confirm-delete/{id}', [App\Http\Controllers\DoctorController::class, 'confirmDelete'])->name('confirmDelete');


//appointment

Route::get('/appointment', [App\Http\Controllers\AppointmentController::class, 'add'])->name('appointment');

Route::post('/appointment', [App\Http\Controllers\AppointmentController::class, 'add'])->name('appointment.store');

Route::get('/successAppointment', [App\Http\Controllers\AppointmentController::class, 'view3'])->name('successAppointment');


Route::get('/get-doctor-unavailable-times/{doctorId}', [App\Http\Controllers\AppointmentController::class, 'getDoctorUnavailableTimes']);

Route::get('/get-doctor-appointments-times/{doctorId}', [App\Http\Controllers\AppointmentController::class, 'getDoctorAppointmentsTimes']);


Route::get('/appointmentPage', [App\Http\Controllers\AppointmentController::class, 'index2'])->name('appointmentPage');

Route::get('/appointment/edit/{id}', [App\Http\Controllers\AppointmentController::class, 'edit'])->name('appointmentEdit');

Route::put('/appointment/update/{id}', [App\Http\Controllers\AppointmentController::class, 'update'])->name('updateAppointment');

Route::delete('/appointment/delete/{id}', [App\Http\Controllers\AppointmentController::class, 'delete'])->name('deleteAppointment');


Route::get('/select-date', function () {
    return view('select-date');
})->name('select.date');


Route::post('/get-users-by-date', [App\Http\Controllers\AppointmentController::class, 'getUsersByDate'])->name('get.users.by.date');


//payment
 
Route::post('/checkout', [App\Http\Controllers\PaymentController::class, 'paymentPost'])->name('payment.post');

Route::get('/payment',[App\Http\Controllers\StripeController::class,'index'])->name('payment');

Route::post('/checkout',[App\Http\Controllers\StripeController::class,'checkout'])->name('checkout');

Route::get('/success',[App\Http\Controllers\StripeController::class,'success'])->name('success');

//video


Route::get('/video',[App\Http\Controllers\videoController::class,'index'])->name('video');


//laravel

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// routes/web.php

Route::get('/test', function () {
    return 'Test route accessed!';
});

