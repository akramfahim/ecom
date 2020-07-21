import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import aboutUs from './pages/about-us'
import privacyPolicy from './pages/privacy-policy'

//Admin Area
import category from './pages/admin/category'
import product from './pages/admin/product'

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
    },
    {
        path: '/product',
        component: product
    }
];

export default new Router ({
    mode: 'history',
    routes
})