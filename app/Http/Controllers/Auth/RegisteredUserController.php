<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if (empty($request->input())) {
            return redirect()->route('register');
        }
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', function ($attribute, $value, $fail) {
                $user = User::filter('email', "=", $value)->scan()->first();
                if ($user) {
                    $fail('The ' . $attribute . ' has already been taken.');
                }
            }],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = $this->userService->create($validated);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.signup');
    }
}
