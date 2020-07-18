import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import aboutUs from './pages/about-us'
import privacyPolicy from './pages/privacy-policy'

const routes = [
    {
        path: '/about-us',
        component: aboutUs
    },
    {
        path: '/privacy-policy',
        component: privacyPolicy
    }
];

export default new Router ({
    mode: 'history',
    routes
})