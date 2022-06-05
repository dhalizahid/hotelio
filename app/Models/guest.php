<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class guest extends Model
{
    use HasFactory;

    protected $table ='guest';
    protected $fillable = [
        'id',
        'Name',
        'Email',
        'Address',
        'Phone',
        'NidNO',
        'Nid',
        'PassportNO',
        'Passport',
        'Father',
        'Photo',
        'Spouse'
    ];
}
