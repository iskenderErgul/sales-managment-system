<template>
    <chat-layout>

        <template #aside>
            <div class="bg-light p-3">
                    Kenar Çubuğu
            </div>
        </template>


        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="bg-primary text-white p-3">
                        <!-- Ana içerik -->
                        hello
                    </div>
                </div>
            </div>
        </div>

        <template #form>
            <div class="bg-secondary p-3 text-white">
                Form Girişi
            </div>
        </template>
    </chat-layout>
</template>

<script setup>
import ChatLayout from "@/layout/ChatLayout.vue";
</script>
