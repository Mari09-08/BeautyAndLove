<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\User;
use DB;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'nombre1' => ['required', 'string', 'max:25'],
            'nombre2' => ['nullable', 'string', 'max:25'],
            'apellido1' => ['required', 'string', 'max:25'],
            'apellido2' => ['nullable', 'string', 'max:25'],
            'fecha' => ['required'],
            'tel' => ['required', 'numeric', 'digits_between:7,15'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'nombre1.required' => 'El primer nombre es obligatorio.',
            'nombre1.max' => 'El primer nombre no puede exceder los 25 caracteres.',

            'nombre2.max' => 'El segundo nombre no puede exceder los 25 caracteres.',

            'apellido1.required' => 'El primer apellido es obligatorio.',
            'apellido1.max' => 'El primer apellido no puede exceder los 25 caracteres.',

            'apellido2.max' => 'El segundo apellido no puede exceder los 25 caracteres.',

            'fecha.required' => 'La fecha de nacimiento es obligatoria.',

            'tel.required' => 'El teléfono es obligatorio.',
            'tel.numeric' => 'El teléfono debe ser un número válido.',
            'tel.digits_between' => 'El teléfono debe tener entre 7 y 15 dígitos.',

            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debes ingresar un correo electrónico válido.',
            'email.unique' => 'Este correo ya está registrado.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Concatenar nombres y apellidos eficientemente
        $fullName = trim($data['nombre1'] . ' ' . $data['nombre2'] . ' ' . $data['apellido1'] . ' ' . $data['apellido2']);

        // Usar una transacción para asegurar la consistencia de los datos
        $dUser = DB::transaction(function () use ($data, $fullName) {
            // Crear el usuario
            $dUser = User::create([
                'name' => $fullName,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'rol' => 3, // Asegurar que se asigne el rol
            ]);

            // Crear el cliente asociado
            Clientes::create([
                'nombre1' => $data['nombre1'],
                'nombre2' => $data['nombre2'],
                'apellido1' => $data['apellido1'],
                'apellido2' => $data['apellido2'],
                'telefono' => $data['tel'],
                'fecha_nacimiento' => $data['fecha'],
                'id_user' => $dUser->id,
            ]);

            // Retornar el usuario creado para autenticación
            return $dUser;
        });

        // Retornar el usuario creado para permitir el login
        return $dUser;
    }
}
