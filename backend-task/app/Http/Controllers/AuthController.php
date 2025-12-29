<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\LoginUserRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Страница входа
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function login() {
        return view('login');
    }

    /**
     * Обработка входа
     * @param  LoginUserRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function authenticate(LoginUserRequest $request)
    {
        $credentials = $request->validated();

        if (!auth()->attempt($credentials)) {
            throw ValidationException::withMessages(['email' => ['Credentials is invalid']]);
        }

        $request->session()->regenerate();

        return redirect()->route('index');
    }

    /**
     * Обработка входа для api
     * @param  LoginUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function authenticateApi(LoginUserRequest $request)
    {
        $credentials = $request->validated();

        if (!auth()->attempt($credentials)) {
            throw ValidationException::withMessages(['email' => ['Credentials is invalid']]);
        }

        $user = auth()->user();

        $token = $user->createToken('token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    /**
     * Регистрация по api
     * @param  CreateUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(CreateUserRequest $request) {
        $validated = $request->validated();

        User::create($validated);

        return response()->json(['success' => true], 201);
    }
}
