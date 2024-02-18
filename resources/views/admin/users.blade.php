@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-black">Manage Users</h1>
    <table class="w-full text-left text-black">
        <thead>
            <tr>
                <th class="py-2 px-4 text-black">Name</th>
                <th class="py-2 px-4 text-black">Email</th>
                <th class="py-2 px-4 text-black">Student ID</th>
                <th class="py-2 px-4 text-black">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="py-2 px-4">{{ $user->name }}</td>
                    <td class="py-2 px-4">{{ $user->email }}</td>
                    <td class="py-2 px-4">{{ $user->student_number }}</td> 
                    <td class="py-2 px-4">
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
