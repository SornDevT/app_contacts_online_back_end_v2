<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// add 
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

// class User extends Authenticatable  old
class User extends Authenticatable implements JWTSubject  // new
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'gender',
        'image',
        'tel',
        'birth_day',
        'add_village',
        'add_city',
        'add_province',
        'add_detail',
        'web',
        'job',
        'job_type',
        'user_type',
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

     /**
                    * Get the identifier that will be stored in the subject claim of the JWT.
                    *
                    * @return mixed
                    */
                    public function getJWTIdentifier()
                    {
                        return $this->getKey();
                    }

                    /**
                    * Return a key value array, containing any custom claims to be added to the JWT.
                    *
                    * @return array
                    */
                    public function getJWTCustomClaims()
                    {
                        return [];
                    }
}
