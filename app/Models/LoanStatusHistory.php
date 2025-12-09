<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanStatusHistory extends Model
{
    /** @use HasFactory<\Database\Factories\LoanStatusHistoryFactory> */
    use HasFactory;
    protected $table = 'loan_status_histories';
    protected $guarded = ['id'];
    protected $casts = ['changed_at' => 'datetime'];

    public function loan()
    { 
        return $this->belongsTo(Loan::class); 
    }

    public function user()
    { 
        return $this->belongsTo(User::class, 'changed_by'); 
    }
}
