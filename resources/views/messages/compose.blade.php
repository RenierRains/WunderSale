@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Compose Message to {{ $user->name }}</h2>
    <form action="{{ route('messages.store') }}" method="POST">
        @csrf
        <input type="hidden" name="to_user_id" value="{{ $user->id }}">
        <textarea name="body" class="w-full rounded border-gray-300" rows="4" required></textarea>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mt-2">
            Send Message
        </button>
    </form>
</div>
@endsection