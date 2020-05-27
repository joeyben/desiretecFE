<template>
    <div class="message-form">
        <textarea name="antworten" id="antworten" v-model="newMessage"></textarea>
        <input id="edit-val" style="display: none;">
        <div class="cu-cl-buttons">
            <button class="primary-btn antworten-btn button-show btn-chat" id="send-button" @click="sendMessage">{{ wordsTrans['write_message'] }}</button>
            <button class="primary-btn antworten-btn  button-hide btn-chat" @click="updateMessage">{{ wordsTrans['save'] }}</button>
            <input type="hidden" name="_token" :value="csrfToken">
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                newMessage: ''
            }
        },

        computed: {
            csrfToken() { window.Laravel.csrfToken; }
        },

        props: ['messages', 'userid', 'wishid', 'groupid', 'username', 'fetch', 'wordsTrans'],

        methods: {
            sendMessage() {
                var self = this;

                var data = {
                    user_id: this.userid,
                    wish_id: this.wishid,
                    group_id: this.groupid,
                    message: this.newMessage
                }

                if($('#antworten').val().length == 0) {
                    $('#antworten').slideDown();
                } else {
                    axios.post('/messages', data).then(response => {
                        $('#antworten').val('');
                        $('#antworten').slideUp();
                        self.$emit('messaged');
                    });
                }

                this.newMessage = ''
            },

            cancel() {
                $('#btn-input').val('');

                $('.button-show span').show();
                $('.loader').hide();
            },

            updateMessage() {
                var self = this;

                var message = this.newMessage;
                var messageid = $('#edit-val').val();

                axios.post('/messages/' + messageid, {
                    message: message,
                }).then(function (response) {
                    $('#antworten').val('');
                    $('#antworten').slideUp();
                    jQuery('#'+messageid+" .message-holder").text(message);

                    $('.button-show').css('display','inline-block')
                    $('.button-hide').css('display','none');
                    self.$emit('messaged');
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
</script>

<style scoped>
    .input-group {
        display: block;
    }

    .input-group-btn {
        text-align: right;
    }

    .btn-chat {
        margin-top: 15px;
    }

    .button-hide {
        display: none;
    }

    .button-hide:last-child {
        margin-left: 10px;
    }
    .loader {
        display:none;
        border: 2px solid #f3f3f3;
        border-radius: 50%;
        border-top: 2px solid #3498db;
        width: 18px;
        height: 18px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
