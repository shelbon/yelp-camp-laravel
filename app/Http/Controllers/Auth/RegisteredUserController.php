<?php

namespace App\Http\Controllers\Auth;

use App\Cognito\CognitoClient;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\GenerateEmailVerificationRouteService;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;
    private UserService $userService;
    private GenerateEmailVerificationRouteService $generateEmailVerificationRouteService;

    public function __construct(UserService $userService, GenerateEmailVerificationRouteService $generateEmailVerificationRouteService)
    {
        $this->middleware('guest');
        $this->userService = $userService;
        $this->generateEmailVerificationRouteService = $generateEmailVerificationRouteService;
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all())->validate();
        //Create credentials object
        $collection = collect($request->all());
        $data = $collection->only('email', 'password'); //passing 'password' is optional.

        $this->validator($request->all())->validate();

        $attributes = [];

        $userFields = ['password', 'email'];

        foreach ($userFields as $userField) {

            if ($request->$userField === null) {
                throw new \Exception("The configured user field $userField is not provided in the request.");
            }

            $attributes[$userField] = $request->$userField;
        }

        app()->make(CognitoClient::class)->register($request->email, $request->password, $attributes);
        $user = $this->create($request->all());
        event(new Registered($user));
        Auth::login($user);
        //Redirect to view
        return redirect($this->generateEmailVerificationRouteService->generate($user->getAuthIdentifier()));
    }

    protected function validator(array $data)
    {
        $messages = [
            'email.required' => 'Email is required.',
            'email.string' => 'The given email is invalid.',
            'email.email' => 'The given email is invalid.',
            'password.confirmed' => 'Password Confirmation should match the Password'
        ];
        return validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', function ($attribute, $value, $fail) {
                $user = User::filter('email', "=", $value)->scan()->first();
                if ($user) {
                    $fail('The ' . $attribute . ' has already been taken.');
                }
            }],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data): User
    {
        return $this->userService->create($data);
    }

    /**
     * Display the registration view.
     *
     * @return View
     */
    public function show()
    {
        $verifyUrl=$this->generateEmailVerificationRouteService->generate((string)auth::user()?->getAuthIdentifier());
        return view('auth.signup',["verifyUrl" => $verifyUrl]);
    }


}
