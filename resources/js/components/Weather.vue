<template>
    <div class="main_wrap min-h-screen flex items-center justify-center">

        <div class="wrapper relative w-35rem">
            <Spinner v-if="loader"></Spinner>
            <div class="search_box mb-10">
                <input type="text" placeholder="Enter your location here" id="address-input"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="weather_wrap bg-gray-900 text-white rounded overflow-hidden font-open-sans">
                <div class="flex current_weather justify-between px-6 py-10">
                    <div class="cw_left flex">
                        <div>
                            <p class="text-5xl font-bold">
                                {{today.temp}}°C
                            </p>
                            <p class="text-base mt-4">Feels like {{today.feelsLike}}°C</p>
                        </div>
                        <div class="ml-10 pt-4">
                            <p class="text-xl font-bold">{{today.text}}</p>
                            <p class="text-sm">{{curLocation.name}}</p>
                        </div>
                    </div>
                    <div class="cw_icon text-right">
                        <img class="w-24" :src="today.icon" alt="icon">
                    </div>
                </div>
                <div class="bg-gray-700 pt-4 pb-4">

                    <div class="next_weeks flex items-center px-6 py-4" v-for="(day, index) in week" :key="index">
                        <p class="text-xl font-bold">{{day.date_epoch | moment('ddd')}}</p>
                        <div class="flex items-center ml-12">
                            <div>
                                <img class="w-12" :src="day.day.condition.icon" alt="">
                            </div>
                            <p class="text-sm ml-4">{{day.day.condition.text}}</p>
                        </div>
                        <div class="text-sm ml-auto text-right">
                            <p>{{mathRound(day.day.maxtemp_c)}}°C</p>
                            <p>{{mathRound(day.day.mintemp_c)}}°C</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import places from 'places.js'
    import Spinner from './Spinner.vue';

    export default {
        components:{
            Spinner,
        },
        data() {
            return {
                loader: true,
                curLocation: {
                    name: 'Dhaka, Bangladesh',
                    lat: '23.8103',
                    lon: '90.4125'
                },
                week: [],
                today: {
                    icon: '',
                    text: '',
                    feelsLike: '',
                    isDay: '',
                    temp: ''
                }
            }
        },
        methods: {
            getDayOfWeek(time) {
                let newDate = new Date(time * 1000)
                let days = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT']

                return days[newDate.getDay()]
            },
            mathRound(nmbr) {
                return Math.round(nmbr)
            },
            getApiData() {
                axios.get(`api/weather/${this.curLocation.lat}/${this.curLocation.lon}`)
                    .then(response => {
                        this.today.icon = response.data.current.condition.icon
                        this.today.text = response.data.current.condition.text
                        this.today.feelsLike = Math.round(response.data.current.feelslike_c)
                        this.today.temp = Math.round(response.data.current.temp_c)
                        this.today.isDay = response.data.current.is_day
                        this.week = response.data.forecast.forecastday
                        this.week.shift()
                        this.loader = false
                    })
            }
        },
        mounted() {
            this.getApiData()
            const placesAutocomplete = places({
                appId: 'plQD0MCBCSMV',
                apiKey: '36c2ac90d918c603216ad0cc2d6248cc',
                container: document.querySelector('#address-input')
            })
            // .configure({
            //     type: 'city',
            // });
            placesAutocomplete.on('change', e => {
                this.loader = true
                this.curLocation.name = e.suggestion.name+', '+e.suggestion.country
                this.curLocation.lat = e.suggestion.latlng.lat
                this.curLocation.lon = e.suggestion.latlng.lng
                this.getApiData()
            });
        }
    }
</script>

<style scoped>

</style>
