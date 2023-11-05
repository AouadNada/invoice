<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\VendorDashboardController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\addUser;
use App\Http\Controllers\addInvoice;
use App\Http\Controllers\invoiceVendorController;
use App\Http\Controllers\invoiceClientController;
use App\Http\Controllers\admins;

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

Route::get('/', function () {
    return view('/welcome/home');
});

// Dashboard Route
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isAdmin()) {
        $lastFiveInvoices = DB::table('invoices')
        ->select('invoices.*', 'users.name')
        ->join('invoice_user', 'invoice_user.invoice_id', '=', 'invoices.id')
        ->join('users', 'users.id', '=', 'invoice_user.user_id')
        ->orderBy('invoices.created_at', 'desc')
        ->limit(5)
        ->get();
        
        $topCountries = DB::table('users')
            ->select('countries.*', DB::raw('count(*) as user_count'))
            ->leftJoin('countries', 'users.country', '=', 'countries.code')
            ->groupBy('users.country', 'countries.name', 'countries.code','countries.id') 
            ->orderByDesc('user_count')
            ->limit(5)
            ->get();

        return view('/admin/dashboard', ['topCountries' => $topCountries], ['lastFiveInvoices' => $lastFiveInvoices]);
    } elseif ($user->isVendor()) {
        $vendor = Auth::user(); // Get the authenticated vendor

        $invoices = $vendor->invoices; // Get the invoices associated with the vendor

        $lastFiveInvoices = $invoices->sortByDesc('created_at')->take(5);
        // Create an array to store user IDs associated with the vendor's invoices
        $userIds = [];
        

        foreach ($invoices as $invoice) {
            // Get associated user IDs using a custom query
            $userIdsForInvoice = DB::table('invoice_user')
                ->join('users', 'invoice_user.user_id', '=', 'users.id')
                ->where('invoice_user.invoice_id', $invoice->id)
                ->where('users.role', 'client')
                ->pluck('users.id')
                ->toArray();

            // Merge the user IDs into the main array
            $userIds = array_merge($userIds, $userIdsForInvoice);
        }

        // Now, you have an array of user IDs associated with the vendor's invoices

        $lastFiveInvoices = $vendor->invoices()
            ->select('invoices.*', 'users.name')
            ->join('invoice_user AS iu1', 'iu1.invoice_id', '=', 'invoices.id')
            ->join('users', 'users.id', '=', 'iu1.user_id')
            ->where('users.role', 'client')
            ->whereIn('users.id', $userIds)
            ->orderBy('invoices.created_at', 'desc')
            ->limit(5)
            ->get();

        // Get the top countries of those users
        $topCountries = DB::table('users')
            ->select('countries.*', DB::raw('count(*) as user_count'))
            ->leftJoin('countries', 'users.country', '=', 'countries.code')
            ->whereIn('users.id', $userIds) // Filter by the user IDs associated with the vendor's invoices
            ->groupBy('users.country', 'countries.name', 'countries.code', 'countries.id')
            ->orderByDesc('user_count')
            ->limit(5)
            ->get();

        return view('/vendor/dashboard', ['topCountries' => $topCountries, 'lastFiveInvoices' => $lastFiveInvoices]);
    } elseif ($user->isClient()) {
    
        $client = Auth::user();
        $invoices = $client->invoices; 

        $lastFiveInvoices = $invoices->sortByDesc('created_at')->take(5);

        return view('/client/dashboard', ['lastFiveInvoices' => $lastFiveInvoices]);
    }

    return view('/welcome/home'); // Default view in case the user doesn't have any of the specified roles
})->middleware('auth')->name('dashboard');
//admin
Route::resource('invoices', InvoiceController::class);
Route::resource('addUser', addUser::class);
Route::post('/addUser/store', [addUser::class, 'store'])->name('addUser.store');
Route::resource('clients', ClientDashboardController::class);
Route::resource('vendors', VendorDashboardController::class);
Route::resource('admins', admins::class);
Route::post('/clients/destroy', [ClientDashboardController::class, 'destroy'])->name('clients.destroy');
Route::post('/invoices/destroy', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
Route::post('/vendors/destroy', [VendorDashboardController::class, 'destroy'])->name('vendors.destroy');
Route::post('/admins/destroy', [admins::class, 'destroy'])->name('admins.destroy');



//vendor
Route::resource('addInvoice', addInvoice::class);
Route::resource('invoicesV', invoiceVendorController::class);
Route::post('/addInvoice/store', [addInvoice::class, 'store'])->name('addInvoice.store');
Route::post('/invoicesV/destroy', [invoiceVendorController::class, 'destroy'])->name('invoicesV.destroy');
Route::post('/addInvoice/edit/{id}', [addInvoice::class, 'edit'])->name('addInvoice.edit');
Route::get('/invoicesV/printInvoice/{invoiceP}', [invoiceVendorController::class, 'printInvoice'])->name('invoicesV.printInvoice');
Route::get('/invoicesV/updateInvoice/{invoiceU}', [invoiceVendorController::class, 'updateInvoice'])->name('invoicesV.updateInvoice');

//clients
Route::resource('invoicesC', invoiceClientController::class);
Route::get('/invoicesC/printInvoice/{invoicePC}', [invoiceClientController::class, 'printInvoice'])->name('invoicesC.printInvoice');
Route::post('/invoicesC/edit/{id}', [invoiceClientController::class, 'edit'])->name('invoicesC.edit');
Route::get('/invoicesC/updateInvoice/{invoiceU}', [invoiceClientController::class, 'updateInvoice'])->name('invoicesC.updateInvoice');
Route::post('/invoicesC/destroy', [invoiceClientController::class, 'destroy'])->name('invoicesC.destroy');


Route::get('/test', function () {
    return view('/admin/test');
})->name('test');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';



