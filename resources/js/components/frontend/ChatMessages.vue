<template>
    <div>
        <div class="col-md-12" :id="message.id" v-for="message in messages" :key="message.id">
            <div v-bind:class="[userid == message.user_id ?  'cu-img-right' : 'cu-img-left']">
                <img v-if="message.avatar" :src="message.avatar">
                <img v-else :src="'/img/frontend/profile-picture/user.png'">
            </div>

            <confirmation-modal v-on:confirm="updateMessages" :id="message.id"></confirmation-modal>
            <div v-bind:class="[userid == message.user_id ?  'cu-comment cu-comment-right' : 'cu-comment cu-comment-left']">
                <p>
                     <span class="username">
                    {{ userid == message.user_id ? 'Ich' : message.name  }}
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
        <message-form v-on:messaged="updateMessages" :username="this.user" :userid="userid" :wishid="wishid" :groupid="groupid"></message-form>
    </div>
</template>

<script>

  import MessageForm from './MessageForm.vue'
  import ConfirmationModal from './ConfirmationModal.vue'
  import moment from 'moment'
  moment.locale('de');
Vue.prototype.moment = moment

export default {
    data () {
        return {
            messages: [],
            user: '',
            avatar: []
        }
    },

    props: ['userid', 'wishid', 'groupid'],

    mounted() {
        this.fetchMessages();
    },

    methods: {

        fetchMessages() {
            axios.get('/messages/'+this.wishid+'/'+this.groupid).then(response => {
                this.messages = response.data.data;
                this.user = response.data.user;
                this.avatar = response.data.avatar;
            }).catch(function (error) {
                console.log(error);
            });
;
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
            return moment(date).fromNow();
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
