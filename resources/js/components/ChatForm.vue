<template>
    <div class="input-group">
        <input
                id="btn-input"
                type="text"
                name="message"
                class="form-control input-sm"
                placeholder="Type your message here..."
                v-model="newMessage"
                @keyup.enter="sendMessage"
                @keyup="sendTypingEvent">

        <span class="input-group-btn">
            <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage">
                Send
            </button>
        </span>
    </div>
</template>

<script>
    export default {
        props: ['user'],

        data() {
            return {
                newMessage: '',
                id:1
            }
        },

        methods: {
            sendTypingEvent() {
                // Echo.join('messages')
                //     .whisper('typing', this.user);
            },

            sendMessage() {
                this.$emit('messagesent', {
                    id: this.id,
                    chat: this.newMessage
                });

                this.newMessage = ''
            }
        }
    }
</script>
