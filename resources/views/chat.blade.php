@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 flex">
    <!-- Chat History Sidebar -->
    <div class="w-1/4 bg-gray-100 p-4 overflow-y-auto">
        <h2 class="font-semibold text-lg mb-4">Chats</h2>
        <template x-for="user in chatUsers" :key="user.id">
            <div class="py-2 px-4 hover:bg-gray-200 cursor-pointer" x-text="user.name" @click="selectUser(user)"></div>
        </template>
    </div>

    <!-- Actual Chat Window -->
    <div class="flex-1 ml-4 bg-white p-4 overflow-y-auto">
        <div x-show="selectedUser">
            <h2 class="font-semibold text-lg" x-text="`Chat with ${selectedUser.name}`"></h2>
            <div class="mt-4" id="messageContainer">
                <!-- Messages will be appended here -->
            </div>
            <div class="mt-4">
                <input type="text" class="border p-2 w-full" placeholder="Type a message..." x-model="newMessage">
                <button class="bg-blue-500 text-white px-4 py-2 rounded mt-2" @click="sendMessage()">Send</button>
            </div>
        </div>
        <div x-show="!selectedUser" class="text-center">
            <p>Select a user to start chatting</p>
        </div>
    </div>
</div>
<script src="https://www.gstatic.com/firebasejs/7.24.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.24.0/firebase-auth.js"></script>
<script>
    const firebaseConfig = {
        apiKey: "{{ env('FIREBASE_API_KEY') }}",
        authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
        databaseURL: "{{ env('FIREBASE_DATABASE_URL') }}",
        projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
    };
    firebase.initializeApp(firebaseConfig);

    async function login(email, password) {
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({email, password}),
        });

        if (response.ok) {
            const { firebaseCustomToken } = await response.json();
            firebase.auth().signInWithCustomToken(firebaseCustomToken).catch(function(error) {
                console.log(error.message);
            });
        } else {
            console.log('Login failed');
        }
    }
</script>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('chat', () => ({
            chatUsers: [],
            selectedUser: null,
            newMessage: '',

            init() {
                this.loadChatUsers();
            },

            loadChatUsers() {
                // Placeholder: Load users with whom the current user has had conversations
                this.chatUsers = [
                    { id: 1, name: 'John Doe' },
                    { id: 2, name: 'Jane Smith' }
                ];
            },

            selectUser(user) {
                this.selectedUser = user;
                this.loadMessages();
            },

            loadMessages() {
                // Placeholder: Load messages for the selected chat
                // You would typically fetch these from Firebase and then append them to the messageContainer div
                const messages = [
                    { text: 'Hi there!', senderId: this.selectedUser.id },
                    { text: 'Hello!', senderId: window.userId }
                    // Example messages
                ];
                const messageContainer = document.getElementById('messageContainer');
                messageContainer.innerHTML = ''; 
                messages.forEach((msg) => {
                    const messageElement = document.createElement('div');
                    messageElement.textContent = msg.text;
                    messageContainer.appendChild(messageElement);
                });
            },

            sendMessage() {
                console.log(`Sending message to ${this.selectedUser.name}: ${this.newMessage}`);
                this.newMessage = '';
            },
        }));
    });
</script>
@endsection



