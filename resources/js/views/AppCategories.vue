<template>
    <div class="card p-fluid">
        <Toolbar class="mb-4">
            <template #start>
                <Button label="New" icon="pi pi-plus" severity="success" class="mr-2" @click="openNew" />
                <Button label="Export" icon="pi pi-upload" severity="help" @click="exportCSV($event)" />
            </template>
        </Toolbar>

        <DataTable
            v-model:editingRows="editingRows"
            :value="filteredCategories"
            editMode="row"
            dataKey="id"
            @row-edit-save="onRowEditSave"
            :pt="{
        table: { style: 'min-width: 50rem' },
        column: {
          bodycell: ({ state }) => ({
            style: state['d_editing'] && 'padding-top: 0.6rem; padding-bottom: 0.6rem'
          })
        }
      }"
        >
            <template #header>
                <div class="flex flex-wrap gap-2 align-items-center justify-content-between">
                    <h4 class="m-0">Manage Categories</h4>
                    <span class="p-input-icon-left"> </span>
                </div>
            </template>
            <Column field="category_id" header="Category ID" style="width: 20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" />
                </template>
            </Column>
            <Column field="category_name" header="Category Name" style="width: 20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" />
                </template>
            </Column>
            <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center"></Column>

        </DataTable>

    </div>
</template>

<script setup>
import { ref, computed } from 'vue';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Toolbar from "primevue/toolbar";
import Button from "primevue/button";


const categories = ref([
    {
        id: 1,
        category_id: 101,
        category_name: 'Categories A',
    },
    {
        id: 2,
        category_id: 102,
        category_name: 'Categories B',
    },
    {
        id: 3,
        category_id: 103,
        category_name: 'Categories C',
    },
]);

const editingRows = ref([]);

const filteredCategories = computed(() => categories.value.map(category => ({ id: category.id, category_id: category.category_id, category_name: category.category_name })));

const onRowEditSave = (event) => {
    const { newData, index } = event;
    categories.value[index] = newData;
};

</script>
