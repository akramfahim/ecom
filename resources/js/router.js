import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import aboutUs from './pages/about-us'
import privacyPolicy from './pages/privacy-policy'

//Admin Area
import category from './pages/admin/category'

const routes = [
    {
        path: '/about-us',
        component: aboutUs
    },
    {
        path: '/privacy-policy',
        component: privacyPolicy
    },

    //Admin Area
    {
        path: '/category',
        component: category
    }
];

export default new Router ({
    mode: 'history',
    routes
})