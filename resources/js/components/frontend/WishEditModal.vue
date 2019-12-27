<template id="wish-edit-modalisSubmitted">
        <div id="edit-wish" class="modal wish-modal-1 fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="alert alert-success alert-dismissible fade" role="alert">
                        <span class="text"></span>
                        <a class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <form id="app"
                          @submit="checkForm"
                          action="#"
                          method="post">

                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Reisewunsch editieren</h4>
                        <p>Stelle einfach und bequem eine Rückrufbitte ein und das<br>
                            zuständige Reisebüro wird sich als bald bei dir melden
                        </p>
                    </div>
                        <div v-if="loading">

                        </div>
                        <p v-if="errors.length">
                            <b>Please correct the following error(s):</b>
                        <ul>
                            <li v-for="error in errors">{{ error }}</li>
                        </ul>
                        </p>
                    <div class="modal-body">
                        <div class="container-fluid">

                            <div class="col-md-12 modal-body-left">
                                <div class="row row-no-padding">
                                    <div class="group col-md-6">
                                        <input class="form-control" type="text" v-model="convertEarliestStart" name="earliest_start">
                                        <label>Von</label>
                                    </div>
                                    <div class="group col-md-6">
                                        <input class="form-control"type="text" v-model="convertLatestReturn" name="latest_return">
                                        <label>Bis</label>
                                    </div>
                                </div>
                                <div class="row row-no-padding">
                                    <div class="group col-md-6">
                                        <select class="form-control" v-model="convertDuration" name="duration">
                                            <option v-for="option in duration_arr" v-bind:value="option">
                                                {{ option }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="group col-md-6">
                                        <input class="form-control" type="number" v-model="wish.budget" name="budget">
                                        <label>Budget</label>
                                    </div>
                                </div>
                                <div class="row row-no-padding">
                                    <div class="group col-md-6">
                                        <input class="form-control" type="text" v-model="wish.destination" name="destination">
                                        <label>Destination</label>
                                    </div>
                                    <div class="group col-md-6">
                                        <select class="form-control" v-model="wish.adults" value="" name="adults">
                                            <option v-for="option in adults_arr" v-bind:value="option">
                                                {{ option }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-no-padding">
                                    <div class="group col-md-6">
                                        <input class="form-control" v-model="wish.kids" name="kids">
                                        <label>Kids</label>
                                    </div>
                                    <div class="group col-md-6">
                                        <input class="form-control" v-model="wish.pets" name="pets">
                                        <label>Pets</label>
                                    </div>
                                </div>
                                <div class="row row-no-padding">
                                    <div class="group col-md-12">
                                        <input
                                                type="submit"
                                                value="Submit"
                                                class="primary-btn"
                                        >
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">

                    </div>
                    </form>
                </div>
            </div>
        </div>
</template>
<script>
    import moment from 'moment'
    moment.locale('de');
    Vue.prototype.moment = moment

    export default {
        data () {
            return {
                wish:{
                    earliest_start:'',
                    latest_return:'',
                    duration:'',
                    budget:'',
                    destination:'',
                    adults:'',
                    kids:'',
                    pets:'',
                },
                loading: false,
                errors: [],
            }
        },
        props: {
            wish_id: {
                type: Number,
                required: true
            },
            adults_arr: {
                type: Array,
                required: true
            },
            duration_arr: {
                type: Array,
                required: true
            },
        },
        methods: {
            getWish: function () {
                this.loading = true;
                axios.get("/getwish/"+this.wish_id)
                    .then((response)  =>  {
                        this.loading = false;
                        this.wish = response.data;
                    }, (error)  =>  {
                        this.loading = false;
                    })
            },
            checkForm: function (e) {
                if (this.destination && this.earliest_start && this.latest_return) {
                    return true;
                }

                this.errors = [];

                if (!this.destination) {
                    this.errors.push('Wo soll es hingehen?');
                }
                if (!this.earliest_start) {
                    this.errors.push('Bitte geben Sie ein Hinreise Datum ein.');
                }
                if (!this.latest_return) {
                    this.errors.push('Bitte geben Sie ein Rückreise Datum ein.');
                }

                e.preventDefault();
            }
        },
        created () {
            this.getWish();
        },
        computed: {
            convertEarliestStart: function () {
                // `this` points to the vm instance
                return moment(this.wish.earliest_start).format('DD.MM.YYYY');
            },
            convertLatestReturn: function () {
                // `this` points to the vm instance
                return moment(this.wish.latest_return).format('DD.MM.YYYY');
            },
            convertDuration: function () {
                // `this` points to the vm instance
                return parseInt(this.wish.duration);
            },
        }

    }
</script>