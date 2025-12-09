<?php

namespace App\Models;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Optional;

class Loan extends Model
{
    /** @use HasFactory<\Database\Factories\LoanFactory> */
    use HasFactory;
    protected $guarded = ['id'];

    public function created_by() { 
        return $this->belongsTo(User::class, 'created_by'); 
    }

    public function reference() { 
        return $this->belongsTo(User::class, 'reference_id'); 
    }

    public function ao() { 
        return $this->belongsTo(User::class, 'ao_id'); 
    }

    public function pillar()
    {
        return $this->belongsTo(Pillar::class, 'pillar_id');
    }

    public function region()
    {
        return $this->belongsTo(Branch::class, 'region_id');
    }

    public function histories()
    {
        return $this->hasMany(LoanStatusHistory::class);
    }

    protected static function booted()
    {
        static::creating(function ($loan) {
            $loan->status ??= 'Register';
        });

        static::created(function ($loan) {
            $loan->histories()->create([
                'new_status' => $loan->status,
                'changed_by' => optional(auth()->user->id),
            ]);
        });

        static::updating(function ($loan) {
            if ($loan->isDirty('status')) {
                $loan->histories()->create([
                    'old_status' => $loan->getOriginal('status'),
                    'new_status' => $loan->status,
                    'reason'     => request()->input('status_reason'),
                    'changed_by' => optional(auth()->user->id),
                ]);

                if ($loan->status === 'Droping' && blank($loan->disbursed_amount)) {
                    $loan->disbursed_amount = $loan->requested_amount;
                }
            }
        });
    }

    public function scopeDisbursedToday($query)
    {
        return $query->where('status', 'Droping')
                     ->whereHas('histories', fn($q) =>
                         $q->where('new_status', 'Droping')
                           ->whereDate('changed_at', today())
                     );
    }
}
