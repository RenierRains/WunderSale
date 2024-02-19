@extends('layouts.app')

@section('content')
    <div id="app">
    <chat-component :conversation-id="{{ $conversationId }}"></chat-component>
    </div>
@endsection