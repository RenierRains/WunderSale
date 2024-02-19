<template>
    <div>
      <div v-for="message in messages" :key="message.id" class="message">
        <p>{{ message.body }}</p>
      </div>
      <input type="text" v-model="newMessage" @keyup.enter="sendMessage">
    </div>
  </template>
  
  <script>
  export default {
    props: ['conversationId'],
    data() {
      return {
        messages: [],
        newMessage: ''
      };
    },
    methods: {
      fetchMessages() {
        axios.get(`/chat/conversations/${this.conversationId}/messages`)
          .then(response => {
            this.messages = response.data;
          });
      },
      sendMessage() {
        axios.post(`/chat/messages`, {
          body: this.newMessage,
          conversation_id: this.conversationId
        }).then(response => {
          this.messages.push(response.data);
          this.newMessage = '';
        });
      }
    },
    mounted() {
    this.fetchMessages();

    Echo.private(`conversation.${this.conversationId}`)
        .listen('MessageSent', (e) => {
        this.messages.push(e.message);
        });
    }
  };
  </script>
  