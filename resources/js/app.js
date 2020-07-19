require('./bootstrap');

window.Vue = require('vue')

//main component

Vue.component('adminapp',require('./components/adminapp').default)
Vue.component('mainapp',require('./components/mainapp'))

// import vue-router page
import router from './router'
//import common js
import common from './common'
Vue.mixin(common)

const app = new Vue({
    el: '#app',
    router
})


