@extends('layouts.app')

@section('content')
<div class="flex flex-col h-screen">
    <div class="flex-grow overflow-y-auto p-4">
        <h3>Messages with {{ $otherUser->name }}</h3>
        <div id="messages" class="space-y-4">
            @foreach ($messages as $message)
                <div class="@if($message->from_user_id == Auth::id()) text-right @else text-left @endif">
                    <div class="inline-block max-w-xs rounded-lg bg-gray-200 p-2">
                        {{ $message->body }}
                        <div class="text-xs text-gray-600">{{ $message->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="p-4 bg-white border-t">
        <form id="messageForm" action="{{ route('messages.store') }}" method="POST">
            @csrf
            <input type="hidden" name="to_user_id" value="{{ $otherUser->id }}">
            <div class="flex space-x-2">
                <textarea name="body" rows="2" class="flex-1 rounded-md border-gray-300 shadow-sm" required></textarea>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Send
                </button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // Function to fetch messages
    function fetchMessages() {
        $.ajax({
            url: "{{ route('messages.fetch', $otherUser->id) }}",
            type: "GET",
            success: function(data) {
                $('#messages').empty(); // Clear the message container
                $.each(data, function(index, message) {
                    const messageElement = `
                        <div class="message ${message.from_user_id == {{ Auth::id() }} ? 'sent' : 'received'}">
                            ${message.body}
                            <span>${message.created_at}</span>
                        </div>
                    `;
                    $('#messages').append(messageElement);
                });
            }
        });
    }

    // Fetch new messages every 5 seconds
    setInterval(fetchMessages, 5000);

    // Send a new message
    $('#messageForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                $('#messageForm')[0].reset(); // Reset the form
                fetchMessages(); // Fetch the latest messages
            }
        });
    });
});
</script>
@endsection
