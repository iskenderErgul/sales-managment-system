<template>
    <div class="card p-fluid">
        <Toolbar class="mb-4">
            <template #start>
                <Button label="New" icon="pi pi-plus" severity="success" class="mr-2" @click="openNew" />
<!--                <Button label="Export" icon="pi pi-upload" severity="help" disabled @click="exportCSV($event)" />-->
            </template>
        </Toolbar>

        <DataTable
            v-model:editingRows="editingRows"
            :value="categories"
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
            <Column field="id" header="Category ID" style="width: 20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" />
                </template>
            </Column>
            <Column field="description" header="Category Description" style="width: 20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" />
                </template>
            </Column>
            <Column field="name" header="Category Name" style="width: 20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" />
                </template>
            </Column>
            <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center"></Column>
            <Column style="width: 10%; min-width: 8rem" bodyStyle="text-align:center">
                <template #body="{ data }">
                    <Button icon="pi pi-trash" outlined rounded severity="danger" @click="confirmDeleteCategory(data)" />
                </template>
            </Column>
        </DataTable>

        <Dialog v-model:visible="customDialogVisible" :style="{ width: '450px' }" header="Custom Dialog" :modal="true" class="p-fluid">
            <template #footer>
                <Button label="Cancel" icon="pi pi-times" text @click="closeCustomDialog" />
                <Button label="OK" icon="pi pi-check" text @click="deleteCategory" />
            </template>
        </Dialog>


        <Dialog v-model:visible="addDialogVisible" :style="{width: '450px'}" header="Add Product" :modal="true" class="p-fluid">

            <div class="field">
                <label for="productName" class="mb-3">Product Name</label>
                <InputText id="productName" v-model="category.name" />
            </div>
            <div class="field">
                <label for="productDescription" class="mb-3">Product Description</label>
                <InputText id="productDescription" v-model="category.description" />
            </div>

            <template #footer>
                <Button label="Cancel" icon="pi pi-times" text @click="closeAddDialog"/>
                <Button label="Save" icon="pi pi-check" text @click="saveCategory" />
            </template>
        </Dialog>




    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import Dialog from "primevue/dialog";
import axios from 'axios';
const category =ref({
    name : '',
    description : ''
})
const categories = ref([]);
const editingRows = ref([]);
const customDialogVisible = ref(false);
const addDialogVisible = ref(false)
let selectedCategoryId = '';
const openDialog = () => {
    customDialogVisible.value=true
};
const closeCustomDialog = () => {
    customDialogVisible.value = false;
};

const openAddDialog = () => {
    addDialogVisible.value=true;
};
const closeAddDialog = () => {
    addDialogVisible.value=false;
};
const openNew = () => {
    openAddDialog();
}

const saveCategory =async () => {
    try {
        const resp = await axios.post('http://127.0.0.1:8000/api/addCategory',category.value);
        console.log(resp);
        category.value = '';
        closeAddDialog();
        getCategories();

    }catch (error) {
        console.error('Kategoriyi silme hatası:', error);
    }


}


const confirmDeleteCategory = async (data) => {

    console.log(data);
    selectedCategoryId = data.id;
     openDialog();
};
const deleteCategory = async () => {
    try {
        const resp = await axios.delete(`http://127.0.0.1:8000/api/deleteCategory/${selectedCategoryId}`);
        console.log('Kategori başarıyla silindi:', resp.data);
    } catch (error) {
        console.error('Kategoriyi silme hatası:', error);
    } finally {
        closeCustomDialog();
        getCategories();
    }
};

onMounted(() => {
    (async () => {
        await getCategories();
    })();
});
const onRowEditSave = async (event) => {
    const { newData, index } = event;
    const updatedCategory = {
        id: newData.id,
        name: newData.name,
        description: newData.description,

    };

    try {
        const resp = await axios.put(`http://127.0.0.1:8000/api/editCategory/${updatedCategory.id}`, updatedCategory);
        getCategories();
    } catch (error) {
    }
};


const getCategories = async () => {
    try {
        const resp = await axios.get('http://127.0.0.1:8000/api/getCategory');
        categories.value = resp.data;
    } catch (error) {
        console.error('Ağ hatası:', error);
    }
};
</script>
