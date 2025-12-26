<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            // RULES VALIDASI

            'name'     => ['required', 'string', 'max:255'],
            // ↑ Nama wajib, string, maksimal 255 char

            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // ↑ unique:users = Cek tabel 'users', kolom 'email'.
            //   Jika email sudah ada, validasi gagal. PENTING!

            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // ↑ confirmed = Laravel akan mencari field bernama 'password_confirmation'
            //   dan memastikan nilainya SAMA PERSIS dengan field 'password'.
            //   Biasanya field ini ada di form register: <input name="password_confirmation">

        ], [
            // CUSTOM MESSAGES
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah terdaftar. Gunakan email lain.',
            'password.min'       => 'Password minimal 8 karakter agar aman.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
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
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'customer',
        ]);
    }
}
