<template>
    <div class="list-container row">
        <div class="col col-lg-12">
            <div class="filter">
                <div class="count">
                    <span v-cloak>{{ total }} {{ translateWord('count', this.total) }}</span>
                </div>
                <div v-if="isSeller" class="filter-action">
                    <select class="selectpicker" v-model="status" ref="select" @change="fetchWishes()">
                        <option v-for="status in statuses" :key="status.value" :value="status">{{ status.translation }}</option>
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
                                <i class="icon_calendar"></i><span class="value">{{ wish.earliest_start | moment("DD.MM.YYYY") }}</span> {{ translateWord('wishes_date_until') }} <span class="value">{{ wish.latest_return | moment("DD.MM.YYYY") }}</span>
                            </li>
                            <li v-if="wish.whitelabel_id !== 276">
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
                            <li v-if="wish.accommodation && wish.whitelabel_id !== 276">
                                <i class="fal fa-map-marker-check"></i><span class="value">{{ wish.accommodation }}</span>
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
                        <a class="primary-btn" :href="getWishLink(wish, wish.manuelFlag)">{{ translations.goto_btn }}</a>
                        <div v-if="isSeller" class="status-change-action">
                            <select class="selectpicker" id="change-status" ref="select" v-model="wish.status" @change="changeStatus(wish.id, wish.status)">
                                <option v-for="status in wishStatuses" :key="status.value" :value="status.value">{{ status.translation }}</option>
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
    props: ['wlName', 'userRole', 'statusesTrans', 'wordsTrans'],
    data() {
        return {
            statuses: [],
            status: {},
            wishStatuses: [],
            filter: '',
            total: '',
            wishes: {},
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
            return JSON.parse(this.wlName).toLowerCase() === 'tui';
        },
        isDkFereinWhitelabel() {
            return JSON.parse(this.wlName).toLowerCase() === 'dk ferien';
        },
    },
    beforeMount() {
        this.initStatuses();
        this.initStatus();
    },
    mounted() {
        this.fetchWishes();
    },
    methods: {
        initStatuses() {
            this.statuses = [
                {
                    value: 1,
                    translation: this.translatedStatuses[0]
                },
                {
                    value: 2,
                    translation: this.translatedStatuses[1]
                },
                {
                    value: 3,
                    translation: this.translatedStatuses[2]
                },
                {
                    value: 4,
                    translation: this.translatedStatuses[3]
                },
            ];
            this.wishStatuses = this.statuses.slice(0, -1);
        },
        initStatus() {
            if (!this.isSeller) {
                this.status = this.statuses[0];
            } else {
                let hasStoredStatus = localStorage.getItem('statusValue') === '1'
                                    || localStorage.getItem('statusValue') === '2'
                                    || localStorage.getItem('statusValue') === '3'
                                    || localStorage.getItem('statusValue') === '4';
                let statusValue = hasStoredStatus ? localStorage.getItem('statusValue') : 1;
                this.status = this.statuses[statusValue - 1];
            }

            if (this.isDkFereinWhitelabel) {
                this.status = this.statuses[0];
            }
        },
        translateWord(word, count) {
            let wordPlural = word + '_plural';
            return count > 1 || count == 0 ? this.translations[wordPlural] : this.translations[word];
        },
        fetchWishes() {
            axios.get('/wishes/getlist?page=' + this.pagination.current_page + '&status=' + this.status.value + '&filter=' + this.filter)
                .then(response => {
                    this.wishes = response.data.data.data;
                    this.pagination = response.data.pagination;
                    this.total = response.data.pagination.total;

                    this.$nextTick(function () {
                        this.loading = false;
                        $('.selectpicker').selectpicker('refresh');
                        localStorage.setItem('statusValue', this.status.value);
                        this.applyColors();
                    });
                }
            )
            .catch(error => {
                console.log(error);
            });
        },
        changeStatus(wishId, wishStatus) {
            axios.post('/wishes/changeWishStatus', {
                status: wishStatus,
                id: wishId,
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
        getWishLink(wish, isManuel) {
            if(isManuel) {
                return '/wishes/'+wish.id;
            } else if(wish.whitelabel_id === 276) {
                return '/offer/listbf/'+wish.id;
            } else {
                return '/offer/list/'+wish.id;
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
