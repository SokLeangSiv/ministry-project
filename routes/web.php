<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Department;
use App\Http\Controllers\pageController;
use App\Http\Controllers\InvestigateController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
// Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
// Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
// Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Route::controller(UserDepartment::class)->group(function(){
// });
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('layouts.master');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/', [pageController::class, 'dashboard'])->name('dashboard');

    Route::get('/cases', [pageController::class, 'displayCases'])->name('cases');

    Route::post('/casesFiltered', [pageController::class, 'casesFilter']);

    Route::get('/case/{case_id}', [pageController::class, 'showCase'])->name('showcase');

    Route::get('/viewcase/{case_id}', [pageController::class, 'viewCase'])->name('viewcase');

    Route::post('/updateCase/{case_id}', [InvestigateController::class, 'storeInvestigate']);

    Route::get('/caseExport', [pageController::class, 'caseExport'])->name('excelExport');

    Route::get('/downloadPdf',[pageController::class, 'downloadPdf'])->name('pdf');

    Route::get('/getfiles/{case_id}/{file}', [pageController::class, 'getFile']);

    Route::get('/dashboardCase', [pageController::class, 'dashboardCase'])->name('dashboardCase');

    Route::get('/dashboardCase', [pageController::class, 'dashboardCase'])->name('dashboardCase');

    Route::get('/report', [pageController::class, 'report'])->name('report');

    Route::get('/changeCredential', [pageController::class,'changeCredential'])->name('changeCredential');

    Route::post('/updateCredentials', [pageController::class,'updateCredentials'])->name('updateCredentials');

    // delete
    Route::get('/deleteFile/{case_number}/{filename}', [pageController::class, 'deleteFile'])->name('deleteFile');
});




require __DIR__ . '/auth.php';
