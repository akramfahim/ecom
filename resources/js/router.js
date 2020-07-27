import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import aboutUs from './pages/about-us'
import privacyPolicy from './pages/privacy-policy'

//Admin Area
import category from './pages/admin/category'
import product from './pages/admin/product'
import order from './pages/admin/order'
import customer from './pages/admin/customer'
import adminusers from './pages/admin/adminusers'
import login from './pages/admin/login'

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
    },
    {
        path: '/orders',
        component: order
    },
    {
        path: '/customers',
        component: customer
    },
    {
        path: '/adminusers',
        component: adminusers
    },
    {
        path: '/login',
        component: login
    }
];

export default new Router ({
    mode: 'history',
    routes
})