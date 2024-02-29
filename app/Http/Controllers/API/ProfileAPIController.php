<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Models\User;
use App\Models\Item;


class ProfileAPIController extends Controller
{
    // Return user profile information in JSON
    public function edit(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }

    // Update user profile and return JSON response
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $user->update($request->validated());
        return response()->json(['message' => 'Profile updated successfully.', 'user' => $user]);
    }
}
