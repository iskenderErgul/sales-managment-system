import { createRouter, createWebHistory } from 'vue-router';
import AppLayout from "@/layout/AppLayout.vue";
import HomeView from "@/views/HomeView.vue";

const routes = [

    {
        path : '/',
        component :AppLayout,
        children :  [
            {
                path : '/',
                component :HomeView
            }


        ]




    }

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
