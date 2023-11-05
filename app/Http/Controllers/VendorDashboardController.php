<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\User;


class VendorDashboardController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendors = DB::table('users')
        ->where('role', 'vendor')
        ->get();

        $vendorsWithInvoiceCounts = [];

        foreach ($vendors as $vendor) {
            $invoiceCount = DB::table('invoice_user')
                ->join('invoices', 'invoice_user.invoice_id', '=', 'invoices.id')
                ->where('invoice_user.user_id', $vendor->id)
                ->count();

            $vendor->invoice_count = $invoiceCount;
            $vendorsWithInvoiceCounts[] = $vendor;
        }

        return view('admin.vendors', ['vendorsWithInvoiceCounts' => $vendorsWithInvoiceCounts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $vendor = User::findOrFail($request->vendor_id);
        $vendor = User::find($request->vendor_id);
        $vendor->delete();
    
        
        return redirect()->route('vendors.index')->with('success', 'vendor deleted successfully.');
    }
}
