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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('application_date');
            $table->string('customer_name');
            $table->text('address');
            $table->string('phone_number');
            $table->decimal('requested_amount', 18, 2);
            $table->integer('tenor_months');
            $table->foreignId('reference_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('pillar_id')->nullable()->constrained('pillars')->nullOnDelete();
            $table->foreignId('ao_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('region_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('survey_number')->nullable();
            // Hasil pencairan
            $table->decimal('disbursed_amount', 18, 2)->nullable();
            $table->decimal('principal_repayment', 18, 2)->default(0);
            $table->decimal('net_disbursement', 18, 2)->nullable();
            $table->enum('status', [
                'Register', 'Proses', 'Proposal', 'Persetujuan',
                'Droping', 'Tolak', 'Batal', 'Tunda'
            ])->default('Register');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
