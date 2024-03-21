<script setup>

import { ref, computed } from 'vue';
import AppConfig from "@/layout/AppConfig.vue";
import InputText from "primevue/inputtext";
import Password from "primevue/password";
import {useStore} from "vuex";
import axios from "axios";


const user =  ref({
    email : null,
    password : null,
})
const store = useStore();
const login = () => {
    store.dispatch('login', user.value);
};


</script>

<template>
    <div class="surface-ground flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden">
        <div class="flex flex-column align-items-center justify-content-center">

            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
                <div class="w-full surface-card py-8 px-5 sm:px-8" style="border-radius: 53px">
                    <div class="text-center mb-5">

                        <div class="text-900 text-3xl font-medium mb-3">Welcome, Isabel!</div>
                        <span class="text-600 font-medium">Sign in to continue</span>
                    </div>

                    <div>
                        <label for="email1" class="block text-900 text-xl font-medium mb-2">Email</label>
                        <InputText id="email1" type="text" placeholder="Email address" class="w-full md:w-30rem mb-5" style="padding: 1rem" v-model="user.email" />

                        <label for="password1" class="block text-900 font-medium text-xl mb-2">Password</label>
                        <Password id="password1" v-model="user.password" placeholder="Password" :toggleMask="true" class="w-full mb-3" inputClass="w-full" :inputStyle="{ padding: '1rem' }"></Password>


                        <Button @click="login" label="Sign In" class="w-full p-3 text-xl">Submit</Button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <AppConfig simple />
</template>
