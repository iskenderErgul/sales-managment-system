import { createRouter, createWebHistory } from 'vue-router';
import AppLayout from "@/layout/AppLayout.vue";
import HomeView from "@/views/HomeView.vue";

import Orders from "@/views/AppOrders.vue";
import Users from "@/views/AppUsers.vue";
import Categories from "@/views/AppCategories.vue";
import Products from "@/views/AppProducts.vue";

const routes = [

    {
        path : '/sys',
        component :AppLayout,
        children :  [
            {
                path : '/sys',
                component :HomeView
            },

            {
                path: '/sys/orders',
                name: 'orders',
                component: Orders
            },
            {
                path: '/sys/users',
                name: 'users',
                component:Users
            },
            {
                path: '/sys/categories',
                name: 'categories',
                component: Categories
            },
            {
                path: '/sys/products',
                component: Products,
                name: 'products'

            }

        ]
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
