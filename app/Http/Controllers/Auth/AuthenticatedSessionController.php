<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\ApiLoginRequest;
use Kreait\Firebase\Factory;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  ApiLoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(ApiLoginRequest $request){
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Authentication failed.',
                ], Response::HTTP_UNAUTHORIZED);
            }
        }

        if ($request->wantsJson()) {
            $user = Auth::user();
            $sanctumToken = $user->createToken('YourAppName')->plainTextToken;

            // Generate Firebase custom token
            $firebase = (new Factory)->withServiceAccount(config('firebase.service_account'))->create();
            $firebaseCustomToken = $firebase->getAuth()->createCustomToken((string) $user->id)->toString();

            return response()->json([
                'error' => false,
                'message' => 'Authentication successful.',
                'sanctum_token' => $sanctumToken,
                'firebase_custom_token' => $firebaseCustomToken,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'student_number' => $user->student_number,
                ]
            ], Response::HTTP_OK);
        }

        $request->session()->regenerate();
        return redirect()->intended(RouteServiceProvider::HOME);
    }   

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
