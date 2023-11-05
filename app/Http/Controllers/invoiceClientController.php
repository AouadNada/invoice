<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class invoiceClientController extends Controller
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
                ->where('role', 'vendor')
                ->pluck('users.name')
                ->implode(', ');
    
            $invoice->userNames = $userNames;
        }

        return view('client.invoices', ['invoices' => $invoices]) ;
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
    public function edit(Request $request,$id)
    {
        $validatedData = $request->validate([
             'amountPaid' => ['nullable', 'string'],
             'amountDue' => ['nullable', 'string'],
        ]);

        // Retrieve the existing invoice
        $invoice = Invoice::findOrFail($id);

        // Update other fields
        
        $invoice ->update([
            'payment_status' =>'Completed',
            'amount_paid' => $validatedData['amountPaid'],
            'balance_due' => $validatedData['amountDue'],

        ]);


        return redirect()->route('invoicesC.index')->with('success', 'Payment completed successfully.');
      
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
    
        
        return redirect()->route('invoicesC.index')->with('success', 'Invoice deleted successfully.');
    }


    public function printInvoice($invoiceP)
    {
        $invoice = \App\Models\Invoice::where('id', $invoiceP)->first() ;
        $items = \App\Models\invoice_item::where('invoice_id', $invoiceP)->get() ;
        $user = $invoice->users();
        $userClient = $invoice->users()->where('role', 'client')->get(); ;
        $userVendor = $invoice->users()->where('role', 'vendor')->get(); ;
        return view('client.printInvoice', ['invoice' => $invoice, 'items' => $items, 'userClient' => $userClient, 'userVendor' => $userVendor]) ;
    }

}
