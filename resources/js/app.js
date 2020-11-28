require('./bootstrap');

// vue require
var Vue = require('vue');

//plugins
Vue.use(require('vue-moment'));

//component
Vue.component('weather-app', require('./components/Weather.vue').default);

//initialize
new Vue({
    el: '#app'
});
