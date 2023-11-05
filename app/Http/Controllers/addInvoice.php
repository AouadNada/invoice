<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\User;
use App\Models\invoice_user;
use App\Models\invoice_item;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class addInvoice extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emails = DB::table('users')
            ->where('role', 'client')
            ->pluck('email')
            ->toArray();
        return view('vendor.addInvoice', ['emails' => $emails]) ;
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
        $validatedData = $request->validate([
             'receiver' => ['required', 'string'],
             'shipping_address' => ['nullable', 'string'],
             'date' => ['required', 'string'],
             'type' => ['required', 'string'],
             'payment_terms' => ['required', 'string'],
             'due_date' => ['required', 'string'],
             'po_number' => ['required', 'string'],
             'productName' => ['array', 'min:1'],
             'quantity' => ['array', 'min:1'],
             'price' => ['array', 'min:1'],
             'totalI' => ['array', 'min:1'],
             'notes' => ['nullable', 'string'],
             'terms' => ['nullable', 'string'],
             'subTotal' => ['required', 'string'],
             'taxRate' => ['required', 'string'],
             'taxAmount' => ['required', 'string'],
             'total' => ['required', 'string'],
             'amountPaid' => ['nullable', 'string'],
             'amountDue' => ['nullable', 'string'],
             'currency' => ['required', 'string'],
             'payment_status' => ['required', 'in:Completed,Pending'],
             'payment_type' => ['required', 'string'],
             'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif|max:2048'], // Example validation rule for image
         ]);
     
        
         // Handle image upload and save the image path to the 'image' column
         if ($request->hasFile('image')) {
            // Store the image in the storage/app/public directory and get its path.
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
        }
     
        $invoice = Invoice::create([
            'date' => $validatedData['date'],
            'total' => $validatedData['total'],
            'payment_terms' => $validatedData['payment_terms'],
            'currency' => $validatedData['currency'],
            'payment_type' => $validatedData['payment_type'],
            'payment_status' => $validatedData['payment_status'],
            'due_date' => $validatedData['due_date'],
            'po_number' => $validatedData['po_number'],
            'shipping_address' => $validatedData['shipping_address'],
            'notes' => $validatedData['notes'],
            'terms' => $validatedData['terms'],
            'type' => $validatedData['type'],
            'subtotal' => $validatedData['subTotal'],
            'tax_rate' => $validatedData['taxRate'],
            'tax_amount' => $validatedData['taxAmount'],
            'amount_paid' => $validatedData['amountPaid'],
            'balance_due' => $validatedData['amountDue'],
            'image' => $imageName,

        ]);

        invoice_user::create([
            'invoice_id' => $invoice->id, 
            'user_id' => auth()->user()->id,
        ]);

        $productNameArray = $validatedData['productName'];
        $quantityArray = $validatedData['quantity'];
        $priceArray = $validatedData['price'];
        $totalArray = $validatedData['totalI'];

        for ($i = 0; $i < count($productNameArray); $i++) {
            invoice_item::create([
                'invoice_id' => $invoice->id,
                'label' => $productNameArray[$i],
                'quantity' => $quantityArray[$i],
                'rate' => $priceArray[$i],
                'amount' => $totalArray[$i],
            ]);
        }

        

        $receiverEmail = $validatedData['receiver']; 
        $receiver = User::where('email', $receiverEmail)->first();
     
        if ($receiver) {
            // User found, so you can proceed with creating the invoice_user record.
            invoice_user::create([
                'invoice_id' => $invoice->id, 
                'user_id' => $receiver->id,
            ]);
        } else {
            // Debugging output to check the value of $receiverEmail.
            dd("User with email '$receiverEmail' not found.");
        }
     
        return redirect()->route('invoicesV.index')->with('success', 'Invoice added successfully.');
       
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
            'receiver' => ['required', 'string'],
             'shipping_address' => ['nullable', 'string'],
             'date' => ['required', 'string'],
             'type' => ['required', 'string'],
             'payment_terms' => ['required', 'string'],
             'due_date' => ['required', 'string'],
             'po_number' => ['required', 'string'],
             'productName' => ['array', 'min:1'],
             'quantity' => ['array', 'min:1'],
             'price' => ['array', 'min:1'],
             'totalI' => ['array', 'min:1'],
             'notes' => ['nullable', 'string'],
             'terms' => ['nullable', 'string'],
             'subTotal' => ['required', 'string'],
             'taxRate' => ['required', 'string'],
             'taxAmount' => ['required', 'string'],
             'total' => ['required', 'string'],
             'amountPaid' => ['nullable', 'string'],
             'amountDue' => ['nullable', 'string'],
             'currency' => ['required', 'string'],
             'payment_status' => ['required', 'in:Completed,Pending'],
             'payment_type' => ['required', 'string'],
             'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif|max:2048'],
        ]);

        // Retrieve the existing invoice
        $invoice = Invoice::findOrFail($id);

        // Handle image update
        if ($request->hasFile('image')) {
            // Store the image in the storage/app/public directory and get its path.
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
        } else {
            // No new image uploaded, set the 'image' field to the old value
            $invoice->image = $invoice->image;
        }

        // Update other fields
        
        $invoice ->update([
            'date' => $validatedData['date'],
            'total' => $validatedData['total'],
            'payment_terms' => $validatedData['payment_terms'],
            'currency' => $validatedData['currency'],
            'payment_type' => $validatedData['payment_type'],
            'payment_status' => $validatedData['payment_status'],
            'due_date' => $validatedData['due_date'],
            'po_number' => $validatedData['po_number'],
            'shipping_address' => $validatedData['shipping_address'],
            'notes' => $validatedData['notes'],
            'terms' => $validatedData['terms'],
            'type' => $validatedData['type'],
            'subtotal' => $validatedData['subTotal'],
            'tax_rate' => $validatedData['taxRate'],
            'tax_amount' => $validatedData['taxAmount'],
            'amount_paid' => $validatedData['amountPaid'],
            'balance_due' => $validatedData['amountDue'],
            'image' => $imageName,

        ]);


        return redirect()->route('invoicesV.index')->with('success', 'Invoice updated successfully.');
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
    public function destroy(string $id)
    {
        //
    }
}
