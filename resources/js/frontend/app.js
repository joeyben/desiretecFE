
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('../bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(require('vue-moment'));
Vue.use(require('vue-js-modal'));
Vue.component('v-select', require('../../../node_modules/vue-select/src/components/Select.vue'))
Vue.component('pagination', require('../components/frontend/PaginationComponent.vue'));
Vue.component('comment', require('../components/frontend/Comment.vue'));
Vue.component('message', require('../components/frontend/Message.vue'));
Vue.component('chat-messages', require('../components/frontend/ChatMessages.vue'));
Vue.component('message-form', require('../components/frontend/MessageForm.vue'));
Vue.component('confirmation-modal', require('../components/frontend/ConfirmationModal.vue'));
Vue.component('wish-edit-modal', require('../components/frontend/WishEditModal.vue'));
Vue.component('note', require('../components/frontend/Note.vue'));

const app = new Vue({
    el: '#app',

    data: {
        data: {},
        status:'new',
        pagination: {
            'current_page': 1
        },
        loading: true,
        messages: '',
        user_name: '',
        filter: '',
    },

    mounted() {
        // TODO: Move fetchWishes() into component called only in wishes/index.blade.php
        this.fetchWishes();

        // Code inside $nextTick will run only after the entire view has been rendered
        this.$nextTick(function () {
            this.applyColors();
        });
    },

    methods: {
        fetchWishes() {
            axios.get('/wishes/getlist?page=' + this.pagination.current_page+'&status=' + this.status + '&filter=' + this.filter)
                .then(response => {
                    this.data = response.data.data.data;
                    this.pagination = response.data.pagination;
                    this.$nextTick(function () {
                        this.loading = false;
                        $('.selectpicker').selectpicker('refresh');
                        this.applyColors();
                    });

                }
            )
            .catch(error => {
                    console.log(error);
            });
        },

        changeStatus(id) {
            axios.post('/wishes/changeWishStatus', {
                status: this.status,
                id: id,
            }).then(response => {
                if(response.data.success == true){
                    window.location.reload();
                }
            })
            .catch(error => {
                console.log(error);
            });
        },

        formatPrice(value) {
            if(value == null){
                return "- ";
            }

            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },

        applyColors() {
            // (Milena) TODO: Use this for all views, except for the layer

            $('.primary-btn, .btn-primary').css({
                'background': brandColor,
                'border': '1px solid ' + brandColor,
                'color': '#fff',
            });
            $('.secondary-btn, .btn-secondary').css({
                'background': '#fff',
                'border': '1px solid ' + brandColor,
                'color': brandColor,
            });
            $("input").focus(function(){
                $(this).css({'border-color': brandColor});
            });
            $("input").blur(function(){
                $(this).css({'border-color': 'inherit'});
            });
            $('.wish-note i').css({
                'color': brandColor,
            });
        },
    }
});

//jquery
$(document).ready(function(){
    $('.sa-p2').css('-webkit-box-orient','vertical')
})
$('.more-details').click(function(){
    $('.sa-p2').css({'display':'block','height':'auto'})
    $(this).css('display','none')
})

$(document).on('submit', 'form.contact_form', function (event) {
    event.preventDefault();
    var form = $(this);
    var data = form.serializeArray();
    var url = form.attr("action");
    var this_modal = form.parents('.modal');
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        success: function(data){
            if(data.success){
                $('#first_name').val('');
                $('#last_name').val('');
                $('#email').val('');
                $('#telephone').val('');
                $('#subject').val('');
                $('#message').val('');
                this_modal.find('.alert-success').removeClass('fade').find('.text').text(data.message);
                window.setTimeout(function(){
                        this_modal.modal('toggle');
                        this_modal.find('.alert-success').addClass('fade');
                }, 3000);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
    return false;
})


$('.antworten-btn').click(function(){
    $('#antworten').slideDown()
    if($(this).hasClass('sendAntworten')){

    }
    $(this).addClass('sendAntworten');
})
