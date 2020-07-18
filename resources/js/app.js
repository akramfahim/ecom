require('./bootstrap');

window.Vue = require('vue')

//main component

Vue.component('adminapp',require('./components/adminapp').default)
Vue.component('mainapp',require('./components/mainapp'))

// import vue-router page
import router from './router'

const app = new Vue({
    el: '#app',
    router
})


