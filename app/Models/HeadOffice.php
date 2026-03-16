<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadOffice extends Model
{
    /** @use HasFactory<\Database\Factories\HeadOfficeFactory> */
    use HasFactory;
    protected $guarded = ['id'];

    public function branch()
    {
        return $this->hasOne(Branch::class);
    }
}
