<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasApiTokens;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'profile_image_url',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $rules = [
        'name' => 'required',
        'username' => 'required|unique:users,username',
        'email' => 'required|email',
        'password' => 'required|min:8',
        'repeat_password' => 'same:password'
    ];

    public static $messages = [
        'name.required' => 'Debe ingresar el apellido y nombre del usuario.',
        'username.required' => 'Debe ingresar el nombre de usuario con el que iniciará sesión',
        'username.unique' => 'El nombre de usuario ingresado ya existe en nuestra base de datos.',
        'email.required' => 'Debe ingresar la dirección de correo electrónico del usuario.',
        'email.email' => 'La dirección de correo electrónico no es válida.',
        'password.required' => 'Debe ingresar una contraseña y debe contener al menos 8 caracteres.',
        'password.min' => 'La contraseña debe contener al menos :min caracteres.',
        'repeat_password.same' => 'Las contraseñas no coinciden.'
    ];

    public function findForPassport($username) {
        return $this->where('username', $username)->first();
    }
}
