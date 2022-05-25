<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'group_id',
        'status',
        'photo',
        'description',
        'personall',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',        
    ];

    protected $appends  = [
        'photo_url'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    
    public function getPhotoUrlAttribute()
    {
        if ($this->photo && Storage::disk('avatars')->exists($this->photo)) {
            return Storage::disk('avatars')->url($this->photo);
        }

        return asset("images/no_profile.jpg");
    }

    public function getStatusBage()
    {
        if ($this->status == 'ACTIVE') {
            return 'statusBageSuccess';
        } elseif ($this->status == 'INACTIVE') {
            return 'statusBageWarnning';
        }
        return 'statusBageDanger';
    }

    public function isAdmin()
    {
       return $this->group_id == 1;
    }
}
