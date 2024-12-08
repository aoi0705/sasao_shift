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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
            'name' => $_SESSION['name'],
            'furigana' => $_SESSION['furigana'],
            'sex' => $_SESSION['sex'],
            'postnumber' => $_SESSION['postnumber'],
            'address' => $_SESSION['address'],
            'train_route' => $_SESSION['train_route'],
            'station' => $_SESSION['station'],
            'mynumber' => $_SESSION['mynumber'],
            'dependent' => $_SESSION['dependent'],
            'dependent_income' => $_SESSION['dependent_income'],
            'dependent_name' => $_SESSION['dependent_name'],
            'dependent_furigana' => $_SESSION['dependent_furigana'],
            'dependent_sex' => $_SESSION['dependent_sex'],
            'email' => $_SESSION['email'],
            'password' => Hash::make($_SESSION['password']),
        ]);
    }
}
