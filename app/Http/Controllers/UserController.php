<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function registerUser(Request $request)
    {

        $data = $request->validate(
            [

                'firstName' => 'required|min:3',
                'lastName' => 'required',
                'email' => 'required',
                'password' => 'required|min:5',
                'confirmPassword' => 'required|same:password'
            ],
            [
                'firstName.required' => 'Obavezno.',
                'firstName.min' => 'Ime mora imati minimalno 3 znaka',
                'lastName.required' => 'Obavezno.',
                'email.required' => 'Obavezno.',
                'password.required' => 'Obavezno.',
                'password.min' => 'Lozinka mora imati najmanje 5 znakova.',
                'confirmPassword.required' => 'Obavezno.',
                'confirmPassword.same' => 'Lozinke se moraju podudarati.'
            ]
        );

        $existMail = User::where('email', $data['email'])->first();

        if ($existMail) {
            return response()->json(['email' => 'Postoji korisnik s tim emailom'], 400);
        }

        $data['password'] = Hash::make($data['password']);
        $data['confirmPassword'] = Hash::make($data['confirmPassword']);
        $user = new User();
        $user->create($data);
        return response()->json(['message' => 'Registracija uspjesna.']);

    }

    public function loginUser(Request $request)
    {
        $data = $request->validate(
            [
                'email' => 'required',
                'password' => 'required',

            ],
            [

                'email.required' => 'Obavezno.',
                'password.required' => 'Obavezno'
            ]
        );


        if (Auth::attempt($data)) {
            $user = Auth::user();
            return response()->json(['poruka' => 'Uspješna prijava', 'user' => $user]);
        } else {

            return response()->json(['poruka' => 'Pogrešan email ili lozinka.']);
        }
    }

    public function isLogged()
    {

        $user = Auth::user();
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(null);
        }
    }
}
