if (typeof Echo !== 'undefined') {
    Echo.private(`messages.${userId}`) // Make sure to dynamically set `userId` somehow
        .listen('.MessageSent', (e) => {
            const messageThread = document.getElementById('messageThread');
            const newMessage = document.createElement('div');
            newMessage.textContent = e.message.body; // Example of adding the message body
            messageThread.appendChild(newMessage);
            // Scroll to the bottom of the message thread
            messageThread.scrollTop = messageThread.scrollHeight;
        });
}
