<template>
    <div class="chat-app">
        <!-- Chat UI goes here -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            messages: [],
            userId: null, // Set this based on the user you're chatting with
        };
    },
    created() {
        this.listenForMessages();
    },
    methods: {
        fetchMessages() {
            axios.get(`/chat/messages/${this.userId}`).then(response => {
                this.messages = response.data;
            });
        },
        sendMessage(message) {
            axios.post('/chat/send', { message: message, user_id: this.userId }).then(response => {
                this.messages.push(response.data);
            });
        },
        listenForMessages() {
            Echo.private(`chat.${this.userId}`)
                .listen('.MessageSent', (e) => {
                    this.messages.push(e.message);
                });
        }
    }
}
</script>
