<template>
    <div class="list-container row">
        <div class="col col-lg-12">
            <div class="filter">
                <div class="count">
                    <span v-cloak>{{ total }} {{ translateWord('count', this.total) }}</span>
                </div>
                <div v-if="isSeller" class="filter-action">
                    <select class="selectpicker" v-model="status" ref="select" @change="fetchWishes()">
                        <option v-for="(status, index) in translatedStatuses" :key="index">{{ status }}</option>
                    </select>
                    <input type="search" class="id-filter" :placeholder="translateWord('search_placeholder')" v-model="filter" @input="fetchWishes()">
                </div>
            </div>
            <div class="skeleton" v-if="loading"></div>
            <div class="list wishlist" v-cloak>
                <div class="list-element" v-for="wish in wishes" :key="wish.id">
                    <div class="image">
                        <a v-if="!wish.layer_image || isTuiWhitelabel" :href="getWishLink(wish.id, wish.manuelFlag)" class="img" :style="{ 'background-image': 'url(https://i.imgur.com/lJInLa9.png)' }"></a>
                        <a v-else :href="getWishLink(wish.id, wish.manuelFlag)" class="img" :style="{ 'background-image': 'url(' + wish.layer_image + ')' }"></a>
                    </div>
                    <div class="main-info">
                        <ul class="info">
                            <li v-if="wish.destination !== '-'">
                                <i class="icon_pin"></i><span class="value">{{ wish.destination }}</span>
                            </li>
                            <li v-if="wish.airport !== '-'">
                                <i class="fa fa-plane"></i><span class="value">{{ wish.airport }}</span>
                            </li>
                            <li v-if="wish.earliest_start !== '0000-00-00' && wish.latest_return !== '0000-00-00'">
                                <i class="icon_calendar"></i><span class="value">{{ wish.earliest_start | moment("DD.MM.YYYY") }}</span> bis <span class="value">{{ wish.latest_return | moment("DD.MM.YYYY") }}</span>
                            </li>
                            <li>
                                <i class="icon_hourglass"></i><span class="value">{{ wish.duration }}</span>
                            </li>
                            <li v-if="wish.adults > 0">
                                <i class="icon_group"></i><span class="value">{{ wish.adults }} {{ translateWord('adults', wish.adults) }}</span>
                            </li>
                            <li v-if="wish.kids > 0">
                                <i class="fal fa-child"></i><span class="value">{{ wish.kids }} {{ translateWord('kids', wish.kids) }}</span>
                            </li>
                            <li v-if="wish.rooms">
                                <i class="fal fa-door-closed"></i><span class="value">{{ wish.rooms }} {{ translateWord('rooms', wish.rooms) }}</span>
                            </li>
                            <li v-if="wish.pets">
                                <i class="fal fa-dog-leashed"></i><span class="value">{{ wish.pets }} {{ translateWord('pets', wish.pets) }}</span>
                            </li>
                            <li v-if="wish.purpose">
                                <i class="fal fa-suitcase"></i><span class="value">{{ wish.purpose }}</span>
                            </li>
                            <li v-if="wish.version === 'destination'">
                                <i class="fal fa-theater-masks"></i><span class="value">{{  wish.events_interested === 0 ? translateWord('not_interested_events') : translateWord('is_interested_events') }}</span>
                            </li>
                            <li v-if="wish.senderEmail">
                                <i class="fal fa-at"></i><span class="value">{{ wish.senderEmail }}</span>
                            </li>
                            <li v-if="wish.created_at">
                                {{ translations.created_at }} <span class="value">{{ wish.created_at | moment("DD.MM.YYYY") }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="action">
                        <div class="wish-top-infos">
                            <span class="wish-id">{{ wish.id }}</span>
                            <template v-if="isSeller">
                                <span class="wish-classification btn-secondary">
                                    <span v-if="wish.manuelFlag"><i class="fal fa-user"></i></span>
                                    <span v-else><i class="fal fa-robot"></i></span>
                                </span>
                                <span v-if="wish.messageSentFlag" class="message-sent btn-secondary">
                                    <i class="fal fa-envelope"></i>
                                </span>
                                <span v-if="wish.offers > 0" :id="translateWord('offer_ex')" class="offer-count btn-secondary">
                                    {{ wish.offers }}
                                </span>
                            </template>
                        </div>
                        <div v-if="wish.budget !== 0" class="budget">{{ formatPrice(wish.budget) }}€</div>
                        <a class="primary-btn" :href="getWishLink(wish.id, wish.manuelFlag)">{{ translations.goto_btn }}</a>
                        <div v-if="isSeller" class="status-change-action">
                            <select class="selectpicker" id="change-status" ref="select" v-model="status" :value="wish.status" @change="changeStatus(wish.id)">
                                <option v-for="(status, index) in translatedStatuses" :key="index">{{ status }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="10" @paginate="fetchWishes()"></pagination>
        </div>
    </div>
</template>

<script>

import Pagination from './PaginationComponent.vue';

export default {
    components: {
        Pagination
    },
    props: ['userRole', 'statusesTrans', 'wordsTrans'],
    data() {
        return {
            status: '',
            statusName: '',
            filter: '',
            total: '',
            wishes: {},
            whitelabel_name: '',
            loading: true,
            pagination: {
                'current_page': 1
            },
        }
    },
    computed: {
        isSeller() {
            return JSON.parse(this.userRole) === "Seller";
        },
        translatedStatuses() {
            return JSON.parse(this.statusesTrans);
        },
        translations() {
            return JSON.parse(this.wordsTrans);
        },
        isTuiWhitelabel() {
            return JSON.parse(this.whitelabel_name).toLowerCase() === 'tui';
        },
        isDkFereinWhitelabel() {
            return JSON.parse(this.whitelabel_name).toLowerCase() === 'dk ferien';
        },
    },
    beforeMount() {
        if(localStorage.getItem('wishesSelectState') === null || this.isDkFereinWhitelabel) {
            this.status = this.translatedStatuses[0];
        } else {
            this.status = localStorage.getItem('wishesSelectState');
        }
    },
    mounted() {
        this.fetchWishes();
    },
    methods: {
        translateWord(word, count) {
            let wordPlural = word + '_plural';
            return count > 1 ? this.translations[wordPlural] : this.translations[word];
        },
        fetchWishes() {
            this.setStatusName();

            axios.get('/wishes/getlist?page=' + this.pagination.current_page + '&status=' + this.statusName + '&filter=' + this.filter)
                .then(response => {
                    this.wishes = response.data.data.data;
                    this.pagination = response.data.pagination;
                    this.total = response.data.pagination.total;
                    this.whitelabel_name = this.wishes.length > 0 ? this.wishes[0].whitelabel_name : '';

                    this.$nextTick(function () {
                        this.loading = false;
                        $('.selectpicker').selectpicker('refresh');
                        localStorage.setItem('wishesSelectState', this.status);
                        this.applyColors();
                    });
                }
            )
            .catch(error => {
                console.log(error);
            });
        },
        setStatusName() {
            let index = this.translatedStatuses.indexOf(this.status);
            let statusNames =['new', 'offer_created', 'completed'];
            this.statusName = statusNames[index];
        },
        changeStatus(id) {
            this.setStatusName();

            axios.post('/wishes/changeWishStatus', {
                status: this.statusName,
                id: id,
            }).then(response => {
                this.fetchWishes();
            })
            .catch(error => {
                console.log(error);
            });
        },
        formatPrice(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        getWishLink(id, isManuel) {
            if(isManuel) {
                return '/wishes/'+id;
            } else {
                return '/offer/list/'+id;
            }
        },
        applyColors() {
            $('.primary-btn').css({
                'background': brandColor, 'border': '1px solid ' + brandColor, 'color': '#fff',
            });
            $('.primary-btn').hover(function(){
                $(this).css({
                    'background': '#fff', 'color': brandColor, 'border': '1px solid ' + brandColor, 'transition': 'all 0.3s',
                });
            }, function() {
                $(this).css({
                    'background': brandColor, 'border': '1px solid ' + brandColor, 'color': '#fff',
                });
            });
            $('.btn-secondary').css({
                'background': '#fff', 'color': brandColor, 'border': '1px solid ' + brandColor, 'transition': 'all 0.3s',
            });
        }
    }
}
</script>
