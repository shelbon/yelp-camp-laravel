<?php

namespace App\Http\Controllers\Auth;

use App\Cognito\CognitoClient;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\UrlHelper;


class VerifyEmailController extends Controller
{

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
    /**
     * Show the email verification notice.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $url=URL::signedRoute("verification.verify");
        return view('auth.verify',["url"=>$url]);
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        $request->validate(['email' => 'required|email', 'confirmation_code' => 'required|numeric']);

        $response = app()->make(CognitoClient::class)->confirmUserSignUp($request->email, $request->confirmation_code);

        if ($response == 'validation.invalid_user') {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans('black-bits/laravel-cognito-auth::validation.invalid_user')]);
        }

        if ($response == 'validation.invalid_token') {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['confirmation_code' => trans('black-bits/laravel-cognito-auth::validation.invalid_token')]);
        }

        if ($response == 'validation.exceeded') {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['confirmation_code' => trans('black-bits/laravel-cognito-auth::validation.exceeded')]);
        }

        if ($response == 'validation.confirmed') {
            return redirect($this->redirectTo)->with('verified', true);
        }

        return redirect($this->redirectTo)->with('verified', true);
    }
    /**
     * Resend the email verification notification.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resend(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = app()->make(CognitoClient::class)->resendToken($request->email);

        if ($response == 'validation.invalid_user') {
            return response()->json(['error' => trans('black-bits/laravel-cognito-auth::validation.invalid_user')], 400);
        }

        if ($response == 'validation.exceeded') {
            return response()->json(['error' => trans('black-bits/laravel-cognito-auth::validation.exceeded')], 400);
        }

        if ($response == 'validation.confirmed') {
            return response()->json(['error' => trans('black-bits/laravel-cognito-auth::validation.confirmed')], 400);
        }

        return response()->json(['success' => 'true']);
    }

//    /**
//     * Mark the authenticated user's email address as verified.
//     *
//     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    public function __invoke(EmailVerificationRequest $request)
//    {
//        if ($request->user()->hasVerifiedEmail()) {
//            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
//        }
//
//        if ($request->user()->markEmailAsVerified()) {
//            event(new Verified($request->user()));
//        }
//
//        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
//    }
}
