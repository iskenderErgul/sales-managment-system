<script setup>
import { ref } from 'vue';

import AppMenuItem from './AppMenuItem.vue';

const model = ref([
    {
        label: 'Home',
        items: [{ label: 'Dashboard', icon: 'pi pi-fw pi-home', to: '/sys' }]
    },
    {
        label: 'Menu',
        items: [
            { label: 'Products', icon: 'pi pi-fw pi-book', to: '/sys/products' },
            { label: 'Orders', icon: 'pi pi-fw pi-shopping-bag', to: '/sys/orders' },
            { label: 'Categories', icon: 'pi pi-fw pi-th-large', to: '/sys/categories' },
            { label: 'ChatGPT', icon: 'pi pi-comment', to: '/sys/chatGPT' },


        ]
    },


]);
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>

    </ul>
</template>

<style lang="scss" scoped></style>
