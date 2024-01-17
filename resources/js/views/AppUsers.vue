<script setup>
import { ref } from 'vue';

const dropdownItems = ref([
    { name: 'Option 1', code: 'Option 1' },
    { name: 'Option 2', code: 'Option 2' },
    { name: 'Option 3', code: 'Option 3' }
]);

const dropdownItem = ref(null);
</script>

<template>
    <div class="grid">
        <div class="col-12 md:col-6">
            <div class="card p-fluid">
                <h5>Vertical</h5>
                <div class="field">
                    <label for="name1">Name</label>
                    <InputText id="name1" type="text" />
                </div>
                <div class="field">
                    <label for="email1">Email</label>
                    <InputText id="email1" type="text" />
                </div>
                <div class="field">
                    <label for="age1">Age</label>
                    <InputText id="age1" type="text" />
                </div>
            </div>
        </div>




    </div>
</template>
