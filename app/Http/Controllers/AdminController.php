<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Item;
use App\Models\Order;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function items()
    {
        $items = Item::all();
        return view('admin.items', compact('items'));
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
    
    public function importUsers(Request $request)
    {
        $file = $request->file('users_csv');
        
        if (($handle = fopen($file->getPathname(), 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                //student_number, name, email
                $student_number = $data[0];
                $name = $data[1];
                $email = $data[2];

                $validator = Validator::make(compact('student_number', 'name', 'email'), [
                    'student_number' => ['required', 'string', 'max:255', 'unique:users'],
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                ]);

                if ($validator->fails()) {
                    //handle if fail?? [maybe not]
                    continue;
                }

                // random password
                $password = Hash::make(Str::random(10));

                // Create the user
                User::create([
                    'student_number' => $student_number,
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    // is_admin maybe
                ]);
            }
            fclose($handle);
        }

        return back()->with('success', 'Users have been successfully imported.');
    }

    public function usersearch(Request $request){
        $search = $request->input('search');

        if (!empty($search)) {
            $users = User::where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('student_number', 'like', '%' . $search . '%')
                ->get();
        } else {
            $users = User::all();
        }

        return view('admin.users', compact('users'));
    }

    public function itemsearch(Request $request){
        $search = $request->input('search');

        if (!empty($search)) {
            $items = Item::where('name', 'like', '%' . $search . '%')
                        ->orWhereHas('user', function($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        })
                        ->get();
        } else {
            $items = Item::all();
        }

        return view('admin.items', compact('items'));
    }

    public function manageOrders(Request $request){
        $search = $request->input('search');

        if (!empty($search)) {
            $orders = Order::where('order_number', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhere('payment_method', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        })
                        ->get();
        } else {
            $orders = Order::all();
        }

        return view('admin.manageOrders', compact('orders'));
    }
}
