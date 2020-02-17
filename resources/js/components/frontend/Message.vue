<template>
    <div class="container">
        <div class="message">
            <h4>
                Neue Nachrichten <span class="glyphicon glyphicon-bell"></span>
            </h4>
            <chat-messages :messages="messages" :avatar="avatar"></chat-messages>
            <message-form></message-form>
        </div>
    </div>
</template>

<script>

export default {
    data () {
      return {
        messages: [],
        avatar: []
      }
    },
    mounted() {
        this.fetchMessages();
    },

    methods: {
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data.data;
                this.avatar = response.data.avatar;
            })
        }
    }
}
</script>

<style scoped>
    .panel{
        margin-bottom: 0;
    }
</style>
