<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\User;


class admins extends Controller
{
    public function index()
    {
        $admins = DB::table('users')
        ->where('role', 'admin')
        ->get();

        $adminsWithInvoiceCounts = [];

        foreach ($admins as $admin) {
            $invoiceCount = DB::table('invoice_user')
                ->join('invoices', 'invoice_user.invoice_id', '=', 'invoices.id')
                ->where('invoice_user.user_id', $admin->id)
                ->count();

            $admin->invoice_count = $invoiceCount;
            $adminsWithInvoiceCounts[] = $admin;
        }

        return view('admin.admins', ['adminsWithInvoiceCounts' => $adminsWithInvoiceCounts]);
    }
}
