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
        Schema::create('cost_shares', function (Blueprint $table) {
            $table->id();
            $table->string('prod_code')->default('42-03-СД');
            $table->string('prod_name')->default('Залоговая недвижимость');
            $table->date('date')->default(date('Y-m-d'));
            $table->decimal('quotes', $precision = 20, $scale = 6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_shares');
    }
};
