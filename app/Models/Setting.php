<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'phone',
        'email',
        'company_name',
        'company_address',
        'facebook',
        'x',
        'linkedin',
        'youtube',
    ];
}
