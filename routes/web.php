<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\SchoolsController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DistributionDistrictController;
use App\Http\Controllers\DistributionSchoolController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\PublicationContractController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\SchoolRequirementController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SupplyController;



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

Auth::routes(['register' => false]);
Route::get('/', function () {
    return redirect()->route('login');
});

// Route::get('/getWards/{id}', [App\Http\Controllers\BranchesController::class, 'GetWardsId'])->name('getWardsId');


Auth::routes();

Route::prefix('/admin')->middleware(['auth', 'is_ban'])->group(function () {
    Route::resource('users', UsersController::class);
    Route::put('user/ban/{id}', [UsersController::class, 'banUser'])->name('ban.user');
    Route::put('user/unban/{id}', [UsersController::class, 'unBanUser'])->name('unban.user');
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);
    Route::put('restore_users/{id}', [UsersController::class, 'restore'])->name('restore.user');
    Route::resource('schools', SchoolsController::class);
    Route::resource('regions', RegionController::class);
    Route::resource('districts', DistrictController::class);
    Route::resource('wards', WardController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::get('suppliers/delete/{id}', [SupplierController::class, 'unDelete'])->name('supplier.undelete');
    Route::resource('school_requirements', SchoolRequirementController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/getDistrictsId/{region_id}', [SupplierController::class, 'GetDistrictsId'])->name('getDistrictsId');
    Route::get('districts_by_region', [AjaxController::class, 'getDistrictsByRegion'])->name('ajax.get_districts_by_region');
    Route::get('get_school_classes', [AjaxController::class, 'getSchoolClasses'])->name('ajax.get_school_classes');
    Route::get('get_list_publications_received', [AjaxController::class, 'listPublicationReceived'])->name('ajax.get_list_publications_received');
    Route::post('ajax.generate_lgas_data', [AjaxController::class, 'storeBulkLGAsData'])->name('ajax.store_bulk_lgas_data');

    Route::get('get_aggregate_number_of_books_required', [AjaxController::class, 'getAggregateNumBookRequired'])->name('ajax.aggregated_num_of_books');
    Route::resource('contracts', ContractController::class);
    Route::put('restore_contracts/{id}', [ContractController::class, 'restore'])->name('contracts.restore');
    Route::resource('books', BookController::class);
    Route::put('restore_books/{id}', [BookController::class, 'restore'])->name('books.restore');
    Route::resource('publications', PublicationController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('authors', AuthorController::class);
    Route::get('publication/{filename}', [FileController::class, 'download'])->name('download.publication');
    Route::resource('receipts', ReceiptController::class);
    Route::post('supplier/contracts/information/', [ReceiptController::class, 'contractInformation'])->name('contract.information');
    Route::get('contracts/{contract_id}/{id}/edit', [PublicationContractController::class, 'edit'])->name('publication_contract.edit');
    Route::post('puplication_contracts/{contract_id}', [PublicationContractController::class, 'store'])->name('publication_contract.store');
    Route::put('contracts/{contract_id}/{id}', [PublicationContractController::class, 'update'])->name('publication_contract.update');
    Route::resource('distribution_districts', DistributionDistrictController::class);
    Route::resource('distribution_schools', DistributionSchoolController::class);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
