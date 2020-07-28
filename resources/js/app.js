require('./bootstrap');

window.Vue = require('vue')

//Import Sweet Alert 2
import VueSweetalert2 from 'vue-sweetalert2';
// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

//main component
Vue.component('adminapp',require('./components/adminapp').default)
Vue.component('mainapp',require('./components/mainapp'))

// import vue-router page
import router from './router'
//import Vuex 
import store from './store'
//import common js
import common from './common'
Vue.mixin(common)



const app = new Vue({
    el: '#app',
    router,
    store
})


