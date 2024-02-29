<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Item;

class AdminAPIController extends Controller
{
    public function users()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }

    public function items()
    {
        $items = Item::all();
        return response()->json(['items' => $items]);
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }

    // notes!!!!: ensure proper auth checin place to secure admin actions
}
