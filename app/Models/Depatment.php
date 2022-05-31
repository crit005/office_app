<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'created_by',
        'status',
        'description',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
