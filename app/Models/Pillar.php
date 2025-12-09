<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pillar extends Model
{
    /** @use HasFactory<\Database\Factories\PillarFactory> */
    use HasFactory;
    protected $guarded = ['id'];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
