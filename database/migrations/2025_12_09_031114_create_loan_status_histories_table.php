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
        Schema::create('loan_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('loans')->onDelete('cascade');
            $table->enum('old_status', [
                'Register', 'Proses', 'Proposal', 'Persetujuan',
                'Droping', 'Tolak', 'Batal', 'Tunda'
            ])->nullable();
            $table->enum('new_status', [
                'Register', 'Proses', 'Proposal', 'Persetujuan',
                'Droping', 'Tolak', 'Batal', 'Tunda'
            ]);
            $table->timestamp('changed_at')->useCurrent();
            $table->text('reason')->nullable();
            $table->foreignId('changed_by')->nullable()->constrained('users');

            $table->index('loan_id');
            $table->index('changed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_status_histories');
    }
};
