<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanDokter extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'hari',
        'jam',
        'jenis',
        'uid',
        'antri',
        'keluhan'
    ];
}
