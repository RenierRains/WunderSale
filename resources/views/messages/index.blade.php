@extends('layouts.app')

@section('content')
<div class="flex flex-col bg-gray-50 min-h-screen">
    <div class="flex flex-grow overflow-hidden"> <!-- Ensure the container grows with flex but doesn’t overflow -->
        <!-- Conversations List -->
        <div class="w-1/4 bg-white overflow-y-auto"> <!-- Make only the list scrollable -->
            <ul>
                @foreach ($conversations as $conversation)
                    <li class="p-4 hover:bg-gray-100">
                        <a href="{{ route('messages.show', $conversation->id) }}">
                            Conversation with {{ $conversation->user->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Placeholder for Message Thread -->
        <div class="flex-1 p-4">
            Select a conversation to view messages.
        </div>
    </div>
</div>
@endsection
