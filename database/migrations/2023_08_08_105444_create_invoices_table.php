<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
                $table->id();
                $table->string('type');
                $table->string('date');
                $table->string('total');
                $table->string('subtotal');
                $table->string('tax_rate');
                $table->string('tax_amount');
                $table->string('payment_terms');
                $table->string('amount_paid')->nullable();
                $table->string('balance_due')->nullable();
                $table->string('currency');
                $table->string('payment_type');
                $table->enum('payment_status', ['Completed', 'Pending'])->default('Pending');
                $table->string('due_date');
                $table->string('po_number');
                $table->string('shipping_address')->nullable();
                $table->text('notes')->nullable();
                $table->text('terms')->nullable();
                $table->softDeletes();
                $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
