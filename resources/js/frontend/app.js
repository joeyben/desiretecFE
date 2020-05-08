
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('../bootstrap');
require('bootstrap-select');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(require('vue-moment'));
Vue.use(require('vue-js-modal'));
Vue.component('v-select', require('../../../node_modules/vue-select/src/components/Select.vue').default)
Vue.component('pagination', require('../components/frontend/PaginationComponent.vue').default);
Vue.component('comment', require('../components/frontend/Comment.vue').default);
Vue.component('message', require('../components/frontend/Message.vue').default);
Vue.component('chat-messages', require('../components/frontend/ChatMessages.vue').default);
Vue.component('message-form', require('../components/frontend/MessageForm.vue').default);
Vue.component('confirmation-modal', require('../components/frontend/ConfirmationModal.vue').default);
Vue.component('wish-edit-modal', require('../components/frontend/WishEditModal.vue').default);
Vue.component('note', require('../components/frontend/Note.vue').default);

Vue.config.devtools = process.env.NODE_ENV === 'development';

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
        total: '',
    },

    mounted() {
        // TODO: Move fetchWishes() into component called only in wishes/index.blade.php
        this.fetchWishes();

        this.$nextTick(function () {
            this.applyColors();
        });
    },

    methods: {
        fetchWishes() {
            axios.get('/wishes/getlist?page=' + this.pagination.current_page + '&status=' + this.status + '&filter=' + this.filter)
                .then(response => {
                    this.data = response.data.data.data;
                    this.pagination = response.data.pagination;
                    this.total = response.data.pagination.total;
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
            $('.primary-btn, .btn-primary').css({
                'background': brandColor,
                'border': '1px solid ' + brandColor,
                'color': '#fff',
            });
            $('.primary-btn, .btn-primary').hover(function(){
                $(this).css({
                    'background': '#fff',
                    'border': '1px solid ' + brandColor,
                    'color': brandColor,
                    'transition': 'all 0.3s',
                });
            }, function() {
                $(this).css({
                    'background': brandColor,
                    'border': '1px solid ' + brandColor,
                    'color': '#fff',
                });
            });

            $('.secondary-btn, .btn-secondary').css({
                'background': '#fff',
                'border': '1px solid ' + brandColor,
                'color': brandColor,
            });
            $('.secondary-btn:not(.wish-classification), .btn-secondary:not(.wish-classification)').hover(function(){
                $(this).css({
                    'background': brandColor,
                    'border': '1px solid ' + brandColor,
                    'color': '#fff',
                    'transition': 'all 0.3s',
                });
            }, function() {
                $(this).css({
                    'background': '#fff',
                    'border': '1px solid ' + brandColor,
                    'color': brandColor,
                });
            });

            $('.link-btn-primary').css({
                'color': brandColor,
            });
            $('.link-btn-secondary').mouseover(function() {
                $(this).css('color', brandColor);
            }).mouseout(function() {
                $(this).css('color','inherit');
            });

            $("input, textarea").focus(function(){
                $(this).css({'border-color': brandColor});
            });
            $("input, textarea").blur(function(){
                $(this).css({'border-color': 'inherit'});
            });
            $("<style type='text/css'>::selection { background-color: " + brandColor + "; color: #fff; }</style>")
                .appendTo("head");
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
});
