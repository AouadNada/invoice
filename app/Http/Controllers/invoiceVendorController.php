<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class invoiceVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Retrieve invoices for the user
        $invoices = $user->invoices;
        foreach ($invoices as $invoice) {
            // Get associated user names using a custom query
            $userNames = DB::table('invoice_user')
                ->join('users', 'invoice_user.user_id', '=', 'users.id')
                ->where('invoice_user.invoice_id', $invoice->id)
                ->where('role', 'client')
                ->pluck('users.name')
                ->implode(', ');
    
            $invoice->userNames = $userNames;
        }

        return view('vendor.invoices', ['invoices' => $invoices]) ;
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
        $invoice = Invoice::findOrFail($request->invoice_id);
        $invoice = Invoice::find($request->invoice_id);
        $invoice->delete();
    
        
        return redirect()->route('invoicesV.index')->with('success', 'Invoice deleted successfully.');
    }


    public function printInvoice($invoiceP)
    {
        $invoice = \App\Models\Invoice::where('id', $invoiceP)->first() ;
        $items = \App\Models\invoice_item::where('invoice_id', $invoiceP)->get() ;
        $user = $invoice->users();
        $userClient = $invoice->users()->where('role', 'client')->get(); ;
        $userVendor = $invoice->users()->where('role', 'vendor')->get(); ;
        return view('vendor.printInvoice', ['invoice' => $invoice, 'items' => $items, 'userClient' => $userClient, 'userVendor' => $userVendor]) ;
    }

    public function updateInvoice($invoiceU)
    {
        $invoice = \App\Models\Invoice::where('id', $invoiceU)->first() ;
        $emails = DB::table('users')
            ->where('role', 'client')
            ->pluck('email')
            ->toArray();
        $items = DB::table('invoice_item')
            ->where('invoice_id', $invoiceU)
            ->get();
        $clientEmails = $invoice->users
            ->where('role', 'client')
            ->pluck('email')
            ->implode('');

        return view('vendor.updateInvoice', ['invoice' => $invoice, 'emails' => $emails, 'items' => $items, 'clientEmails' => $clientEmails]) ;
    }
}
