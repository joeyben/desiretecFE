<template>
    <div>
        <div class="chat-messages" :id="message.id" v-for="message in messages" :key="message.id">
            <div v-bind:class="[userid == message.user_id ?  'cu-img-right' : 'cu-img-left']">
                <img v-if="message.avatar" :src="message.avatar" class="avatar-size-1 avatar-circle">
                <img v-else :src="'/img/user.png'" class="avatar-size-1 avatar-circle">
            </div>

            <confirmation-modal v-on:confirm="updateMessages" :id="message.id"></confirmation-modal>
            <div v-bind:class="[userid == message.user_id ?  'cu-comment cu-comment-right' : 'cu-comment cu-comment-left']">
                <p>
                     <span class="username">
                    {{ userid == message.user_id ? wordsTrans['me'] : message.name  }}
                    </span>

                    <span v-if="userid == message.user_id" class="action_buttons">
                        <i v-on:click="editMessage(message.id, message.message)" class="fal fa-edit"></i>
                        <i v-on:click="showModal(message.id)" class="fal fa-trash-alt"></i>
                    </span>

                    <span>{{ timestamp(message.created_at) }}</span>
                    <span class="pre-formatted" v-html="message.message">{{ message.message }}</span>
                </p>
                <b style="font-weight:100; display: none;" class="message-holder">{{ message.message }}</b>
            </div>
        </div>
        <message-form v-on:messaged="updateMessages" :wordsTrans="wordsTrans" :username="this.user" :userid="userid" :wishid="wishid" :groupid="groupid"></message-form>
    </div>
</template>

<script>

    import MessageForm from './MessageForm.vue'
    import ConfirmationModal from './ConfirmationModal.vue'
    import moment from 'moment'

    Vue.prototype.moment = moment

    export default {
        data () {
            return {
                messages: [],
                user: '',
                avatar: []
            }
        },

        props: ['userid', 'wishid', 'groupid', 'wordsTrans'],

        mounted() {
            this.fetchMessages();
        },

        methods: {

            fetchMessages() {
                axios.get('/messages/'+this.wishid+'/'+this.groupid).then(response => {
                    this.messages = response.data.data;
                    this.user = response.data.user;
                    this.avatar = response.data.avatar;
                    this.addHrefs();
                }).catch(function (error) {
                    console.log(error);
                });
            },

            editMessage(messageid, message) {

                $('#antworten').slideDown()

                $('#antworten').val('');
                $('#antworten').val(jQuery('#'+messageid+" .message-holder").text());
                $('#edit-val').val(messageid);

                $('.button-show').css('display','none')
                $('.button-hide').css('display','inline-block')

            },

            showModal(id) {
                $('.hidden-popup-val').val(id)
                $('.confirm-popup').show();
                $('body').css('overflow', 'hidden');
            },

            updateMessages () {
                this.fetchMessages();
            },

            timestamp(date) {
                moment.locale(this.wordsTrans['local']);
                return moment(date).fromNow();
            },

            addHrefs() {
                this.messages.forEach((value, index) => {
                    const URLMatcher = /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/igm

                    if(value.message.match(URLMatcher)) {
                        const withLinks = value.message.replace(URLMatcher, match => `<a href="${match}" target="_blank" style="color:#6897b1;">${match}</a>`)

                        this.messages[index].message = withLinks;
                    }
                });
            }
        }
    };
</script>

<style scoped>

    .chat{
        list-style: none;
        padding-left: 0px;
    }

    .user{
        display: block;
        font-weight: 700;
    }

    .date-created{
        display: block;
        color: #ccc;
        font-size: 12px;
    }

    .close_button i{
        float: right;
        cursor: pointer;
    }

    .edit_button i{
        margin-right: 15px;
        float: right;
        cursor: pointer;
    }

    .action_buttons{
        position:absolute;
        top:20px;
        right:15px;
    }

    .action_buttons .fa-edit {
        margin-right:5px;
    }

    .action_buttons i {
        cursor: pointer;
    }

</style>
