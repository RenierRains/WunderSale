@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Users</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <!-- Add more fields as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
