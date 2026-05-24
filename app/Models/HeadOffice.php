<?php

namespace App\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeadOffice extends Model
{
    /** @use HasFactory<\Database\Factories\HeadOfficeFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}
