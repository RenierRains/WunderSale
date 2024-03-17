<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
 
    public function index(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $user->update($request->validated());
        return response()->json(['message' => 'Profile updated successfully.', 'user' => $user]);
    }
    public function showSellerProfile(User $user)
    {

    $userData = [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'student_number' => $user->student_number, 
    ];

    $items = $user->items()->get(['id', 'name', 'description', 'price', 'quantity'])->toArray();


    return response()->json([
        'user' => $userData,
        'items' => $items,
    ]);
}
}
