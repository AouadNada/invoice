<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = DB::select('select * from invoices');
 
        foreach ($invoices as $invoice) {
            // Get associated user names using a custom query
            $userNames = DB::table('invoice_user')
                ->join('users', 'invoice_user.user_id', '=', 'users.id')
                ->where('invoice_user.invoice_id', $invoice->id)
                ->pluck('users.name')
                ->implode(', ');
    
            $invoice->userNames = $userNames;
        }

        return view('admin.invoices', ['invoices' => $invoices]) ;
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
    
        
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
