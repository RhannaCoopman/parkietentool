<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'stamnr' => ['required', 'string', 'min:3', 'max:7', 'unique:stamnr'],
            'name' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'address_street' => ['required', 'string', 'max:255'],
            'address_nr' => ['required', 'numeric'],
            'address_zipcode' => ['required', 'numeric', 'digits:4'],
            'address_city' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'phone' => ['required', 'string', 'digits_between:9,12'],
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2, 
            'stamnr' => 'F' . $request->lastname[0] . 1,
            'name' => $request->name,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname, 
            'address_street' => $request->address_street, 
            'address_nr' => $request->address_nr, 
            'address_zipcode' => $request->address_zipcode, 
            'address_city' => $request->address_city, 
            'birthdate' => $request->birthdate, 
            'phone' => $request->phone, 
            'active' => 1, 
        ]);

        event(new Registered($user));

        return redirect()->route('users.home')->with('success', 'Je hebt succesvol een nieuwe gebruiker aangemaakt. ');

    }
}
