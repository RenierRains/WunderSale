<template>
    <div class="container py-4">
        <div class="row">
            <!-- Chat sessions list -->
            <div class="col-4">
                <div class="list-group">
                    <a 
                        href="#" 
                        class="list-group-item list-group-item-action" 
                        v-for="user in users" 
                        :key="user.id" 
                        @click.prevent="selectUser(user)"
                    >
                        {{ user.name }}
                    </a>
                </div>
            </div>
            <!-- Active chat -->
            <div class="col-8">
                <div v-if="activeUser">
                    <h5>Chatting with {{ activeUser.name }}</h5>
                    <div class="border rounded p-3 mb-3" style="height: 300px; overflow-y: scroll;">
                        <p v-for="message in messages" :key="message.id" :class="{'text-end': message.from_user_id === userId}">
                            {{ message.body }}
                        </p>
                    </div>
                    <input type="text" v-model="newMessage" @keyup.enter="sendMessage" class="form-control">
                </div>
                <div v-else class="text-center">
                    <p>Select a user to start chatting</p>
                </div>
            </div>
        </div>
    </div>
    </template>
    
    <script>
    export default {
        data() {
            return {
                users: [], // List of users to chat with
                activeUser: null,
                messages: [],
                newMessage: '',
                userId: null, // ID of the current user
            };
        },
        methods: {
        fetchUsers() {
            axios.get('/api/users').then(response => {
                this.users = response.data;
            }).catch(error => {
                console.error("There was an error fetching the users: ", error);
            });
        },
        selectUser(user) {
            this.activeUser = user;
            this.messages = []; // Clear previous messages
            this.fetchMessages();
        },
        fetchMessages() {
            axios.get(`/api/messages/${this.activeUser.id}`).then(response => {
                this.messages = response.data;
            }).catch(error => {
                console.error("There was an error fetching the messages: ", error);
            });
        },
        sendMessage() {
            const message = this.newMessage.trim();
            if (message !== '') {
                axios.post('/api/messages/send', { body: message, to_user_id: this.activeUser.id })
                    .then(response => {
                        this.messages.push(response.data);
                        this.newMessage = '';
                    })
                    .catch(error => {
                        console.error("There was an error sending the message: ", error);
                    });
            }
        }
    },
    mounted() {
        this.userId = document.head.querySelector('meta[name="user-id"]').content;
        // Listen for real-time
        Echo.private(`chat.${this.userId}`)
            .listen('.MessageSent', (e) => {
                if (e.message.from_user_id === this.activeUser.id || e.message.to_user_id === this.activeUser.id) {
                    this.messages.push(e.message);
                }
            });
    }
    }
    </script>
    