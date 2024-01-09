<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'password' => 'hashed',
    ];

    protected static function boot(){
        parent::boot();
        static::created(function($user){
            $user->profile()->create();
        });
    }

    //Relation 1:1 with Profile
    public function profile(){
        return $this->hasOne(Profile::class);
    }

    //Relation 1:N with Article
    public function article(){
        return $this->hasMany(Article::class);
    }

    //Relation 1:N with Comment
    public function comment(){
        return $this->hasMany(Comment::class);
    }

    public function adminlte_image(){
        return asset('storage/'. Auth::user()->profile->photo);
    }
}
