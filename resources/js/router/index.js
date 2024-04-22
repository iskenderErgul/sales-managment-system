import { createRouter, createWebHistory } from 'vue-router';
import AppLayout from "@/layout/AppLayout.vue";
import HomeView from "@/views/HomeView.vue";
import Login from "@/pages/Login.vue";
import Orders from "@/views/AppOrders.vue";
import Users from "@/views/AppUsers.vue";
import Categories from "@/views/AppCategories.vue";
import Products from "@/views/AppProducts.vue";
import store from "@/store/index.js";
import ChatGPT from "@/views/ChatGPT.vue";

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

            },
            {
                path : '/sys/chatGPT',
                component: ChatGPT,
                name: 'chatGPT'
            }

        ]
    },
    {
        path: '/login',
        component:Login,
        name : 'login',

    },


];

const router = createRouter({
    history: createWebHistory(),
    routes,
});
router.beforeEach(async (to, from, next) => {
    try {
        await store.dispatch('authenticate');
        if (store.getters.authenticated || to.name === 'login') {
            next();
        } else {
            next({ name: 'login' });
        }
    } catch (error) {
        console.error('Authentication error:', error);
        next({ name: 'login' });
    }
});

export default router;
