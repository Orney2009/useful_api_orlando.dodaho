<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {   
        try{
            
            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|lowercase|email|unique:users',
                'password' => 'required|min:8'
            ]);
        } catch(ValidationException $error){
            return response()->json([
                "message" => "you should provide right values",
            ], 422);
        } 
        
        $user = User::create([
            'name' => $validated["name"],
            'email' => $validated["email"],
            'password' => Hash::make(str($validated['password'])),
        ]);
        
        /* event(new Registered($user));

        Auth::login($user); */        
    
        return response()->json([
            $user        
        ], 201);
        
    }
}
