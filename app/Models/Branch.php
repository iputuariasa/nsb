<?php

namespace App\Models;

use App\Models\HeadOffice;
use App\Models\Kiosk;
use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    /** @use HasFactory<\Database\Factories\BranchFactory> */
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function headOffice()
    {
        return $this->belongsTo(HeadOffice::class);
    }

    public function kiosks()
    {
        return $this->hasMany(Kiosk::class);
    }
}
