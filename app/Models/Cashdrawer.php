<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashdrawer extends Model
{
    use HasFactory;

    protected $fillable=[
        "name",
        "balance",
        "group",
        "owner",
        "description",
        "status"
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'owner');
    }


}
