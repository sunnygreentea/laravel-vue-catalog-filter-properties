<template>
	<div class="container">
		<div class="row">
			<div class="col-md-3 mb-4">
				<h2 class="mt-4">Filters</h2>
                
                <hr>
                <h3 class="mt-2">Prices</h3>
                <div class="form-check" v-for="(price, index) in prices">
                    <input class="form-check-input" type="checkbox" :value="index" :id="'price'+index" v-model="selected.prices">
                    <label class="form-check-label" :for="'price' + index">
                        {{ price.name }} ({{ price.listings_count }})
                    </label>
                </div>

                <hr>
                <h3 class="mt-2">Types</h3>
                <div class="form-check" v-for="(propertytype, index) in propertytypes">
                    <input class="form-check-input" type="checkbox" :value="propertytype.id" :id="'propertytype'+index" v-model="selected.propertytypes">
                    <label class="form-check-label" :for="'propertytype' + index">
                        {{ propertytype.name }} ({{ propertytype.listings_count }})
                    </label>
                </div>

                <hr>
                <h3 class="mt-2">Cities</h3>
                <div class="form-check" v-for="(city, index) in cities">
                    <input class="form-check-input" type="checkbox" :value="city.id" :id="'city'+index" v-model="selected.cities">
                    <label class="form-check-label" :for="'city' + index">
                        {{ city.name }} ({{ city.listings_count }})
                    </label>
                </div>
			</div>
			<div class="col-md-9 mb-4">
				<div class="row mt-4">
					<div class="col-12">
						<h1>Properties</h1>
					</div>
                    <div class="col-lg-4 col-md-6 mb-4" v-for="listing in listings">
                        <div class="card h-100 border-primary">
                            <a href="#">
                                <img class="card-img-top" v-bind:src="'img/listing-' + listing.id+'.jpg'" alt="">
                            </a>
                            <div class="card-body">
                                <h4 class="card-title" style="height:50px;">
                                    <a href="#">{{ listing.name }}</a>
                                </h4>
                                <h5>$ {{ listing.price }}</h5>
                                <p class="card-text"><b>{{ listing.propertytype }} - {{ listing.city }}</b></p>                                
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
        data: function () {
            return {
                prices: [],
                cities: [],
                propertytypes: [],
                listings: [],
                loading: true,
                selected: {
                    prices: [],
                    cities: [],
                    propertytypes: []
                }
            }
        },

        mounted() {
        	this.fetchCities();
        	this.fetchPropertytypes();
            this.fetchPrices();
            this.fetchListings();

        },

        watch: {
        	selected: {
            	handler() {
                    this.fetchCities();
                    this.fetchPropertytypes();
                    this.fetchPrices();
                    this.fetchListings();
                },
                deep: true
            }
        },

        methods: {
           
            fetchListings () {
            	axios.get('api/listings', {
            		params: this.selected
            	})
                .then(res => {
                    this.listings = res.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchCities () {
            	axios.get('api/cities', {
                        params: _.omit(this.selected, 'cities')
                    })
                .then(res => {
                    this.cities = res.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchPropertytypes () {
            	axios.get('api/propertytypes', {
            		params: _.omit(this.selected, 'propertytypes')
            	})
                .then(res => {
                    this.propertytypes = res.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchPrices () {
                axios.get('api/prices', {
                    params: _.omit(this.selected, 'prices')
                })
                .then(res => {
                    this.prices = res.data;
                })
                .catch(err => console.log(err));
            },
        }
    }
</script>