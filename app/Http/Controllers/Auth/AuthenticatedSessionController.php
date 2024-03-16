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
    public function store(ApiLoginRequest $request)
    {
        // Attempt to authenticate the user with the provided credentials
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            // Authentication failed
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Authentication failed.',
                ], Response::HTTP_UNAUTHORIZED);
            }
            // Optionally handle non-JSON authentication failure response here.
        }

        // Authentication successful
        if ($request->wantsJson()) {
            $user = Auth::user();
            $token = $user->createToken('YourAppName')->plainTextToken;
            
            return response()->json([
                'error' => false,
                'message' => 'Authentication successful.',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'student_number' => $user->student_number, // Ensure your User model has this attribute
                ]
            ], Response::HTTP_OK);
        }

        // Handle web request after successful authentication
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
