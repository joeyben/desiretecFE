
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
Vue.component('pagination', require('../components/frontend/PaginationComponent.vue').default);
Vue.component('comment', require('../components/frontend/Comment.vue').default);
Vue.component('message', require('../components/frontend/Message.vue').default);
Vue.component('chat-messages', require('../components/frontend/ChatMessages.vue').default);
Vue.component('message-form', require('../components/frontend/MessageForm.vue').default);
Vue.component('confirmation-modal', require('../components/frontend/ConfirmationModal.vue').default);
Vue.component('wish-edit-modal', require('../components/frontend/WishEditModal.vue').default);
Vue.component('note', require('../components/frontend/Note.vue').default);
Vue.component('wish-list', require('../components/frontend/WishList.vue').default);

Vue.config.devtools = process.env.NODE_ENV === 'development';

const app = new Vue({
    el: '#app',

    mounted() {
        this.$nextTick(function () {
            this.applyColors();
        });
    },

    methods: {
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
                $(this).css({'border-bottom-color': brandColor});
            });
            $("input, textarea").blur(function(){
                $(this).css({'border-color': '#ccc'});
            });
            $("<style type='text/css'>::selection { background-color: " + brandColor + "; color: #fff; }</style>")
                .appendTo("head");
        },
    }
});
