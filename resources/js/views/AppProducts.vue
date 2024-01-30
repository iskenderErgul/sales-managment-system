
<template>
    <div>
        <div class="card">
            <Toolbar class="mb-4">
                <template #start>
                    <Button label="New" icon="pi pi-plus" severity="success" class="mr-2" @click="openNew" />
                    <Button label="Delete" icon="pi pi-trash" severity="danger" @click="confirmDeleteSelected" :disabled="!selectedProducts || !selectedProducts.length" />
                </template>
                <template #end>
                    <FileUpload mode="basic" accept="image/*" :maxFileSize="1000000" label="Import" chooseLabel="Import" class="mr-2 inline-block" />
                    <Button label="Export" icon="pi pi-upload" severity="help" @click="exportCSV($event)"  />
                </template>
            </Toolbar>
            <DataTable ref="dt" :value="products" v-model:selection="selectedProducts" dataKey="id"
                       :paginator="true" :rows="10" :filters="filters"
                       paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5,10,25]"
                       currentPageReportTemplate="Showing {first} to {last} of {totalRecords} products">
                <template #header>
                    <div class="flex flex-wrap gap-2 align-items-center justify-content-between">
                        <h4 class="m-0">Manage Products</h4>
                        <span class="p-input-icon-left"></span>
                    </div>
                </template>
                <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column>
                <Column field="id" header="Id" sortable style="min-width:12rem"></Column>
                <Column field="name" header="Name" sortable style="min-width:16rem"></Column>
                <Column header="Image">
                    <template #body="slotProps">
                        <img :src="slotProps.data.image" :alt="slotProps.data.image" class="shadow-2 border-round" style="width: 64px" />
                    </template>
                </Column>
                <Column field="price" header="Price" sortable style="min-width:8rem">
                    <template #body="slotProps">
                        {{formatCurrency(slotProps.data.price)}}
                    </template>
                </Column>
                <Column field="stock_quantity" header="Quantity" sortable style="min-width:10rem"></Column>
                <Column field="categoryName" header="Category" sortable style="min-width:10rem"></Column>


                <Column :exportable="false" style="min-width:8rem">
                    <template #body="slotProps">
                        <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="editProduct(slotProps.data)" />
                        <Button icon="pi pi-trash" outlined rounded severity="danger" @click="confirmDeleteProduct(slotProps.data)" />
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="productDialog" :style="{width: '450px'}" header="Product Details" :modal="true" class="p-fluid">

            <div class="field">
                <label for="productName" class="mb-3">Product Name</label>
                <InputText id="productName" v-model="product.name" />
            </div>

            <div class="field">
                <label for="productImage" class="mb-3">Product Image</label>
                <FileUpload id="productImage" v-model="product.image" mode="basic" accept="image/*" :maxFileSize="1000000" label="Choose" chooseLabel="Choose" />
            </div>


            <div class="field">
                <label class="mb-3">Category</label>
                <div class="formgrid grid">
                    <div v-for="category in categories" :key="category.id" class="field-radiobutton col-6">
                        <RadioButton :id="`category${category.id}`" name="category" :value="category.name" v-model="product.category" />
                        <label :for="`category${category.id}`">{{ category.name }}</label>
                    </div>
                </div>
            </div>

            <div class="formgrid grid">
                <div class="field col">
                    <label for="price">Price</label>
                    <InputNumber id="price" v-model="product.price" mode="currency" currency="USD" locale="en-US" />
                </div>
                <div class="field col">
                    <label for="quantity">Quantity</label>
                    <InputNumber id="quantity" v-model="product.quantity" integeronly />
                </div>
            </div>
            <template #footer>
                <Button label="Cancel" icon="pi pi-times" text @click="hideDialog"/>
                <Button label="Save" icon="pi pi-check" text @click="saveProduct" />
            </template>
        </Dialog>

        <Dialog v-model:visible="deleteProductDialog" :style="{width: '450px'}" header="Confirm" :modal="true">
            <div class="confirmation-content">
                <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                <span v-if="product">Are you sure you want to delete <b>{{product.name}}</b>?</span>
            </div>
            <template #footer>
                <Button label="No" icon="pi pi-times" text @click="deleteProductDialog = false"/>
                <Button label="Yes" icon="pi pi-check" text @click="deleteProduct" />
            </template>
        </Dialog>

        <Dialog v-model:visible="deleteProductsDialog" @confirm="confirmAction" :style="{width: '450px'}" header="Confirm" :modal="true">
            <div class="confirmation-content">
                <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                <span v-if="product">Are you sure you want to delete the selected products?</span>
            </div>
            <template #footer>
                <Button ref="noButton" label="No" icon="pi pi-times" text @click="deleteProductsDialog = false"/>
                <Button ref="yesButton" label="Yes" icon="pi pi-check" text @click="deleteSelectedProducts" />
            </template>
        </Dialog>
    </div>
</template>

<script setup>
import {onMounted, ref} from 'vue';
import axios from "axios";
import { FilterMatchMode } from 'primevue/api';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import Toolbar from 'primevue/toolbar';
import Dialog from 'primevue/dialog';
import RadioButton from 'primevue/radiobutton';
import FileUpload from 'primevue/fileupload';
import InputNumber from 'primevue/inputnumber';
import InputText from 'primevue/inputtext';


const dt = ref();
const products = ref([]);
const categories = ref([]);
const productDialog = ref(false);
const deleteProductDialog = ref(false);
const deleteProductsDialog = ref(false);
const product = ref({});
const selectedProducts = ref();
const selectedProductsToDelete = ref([]);
const filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
});
const submitted = ref(false);

const formatCurrency = (value) => {
    if(value)
        return value.toLocaleString('en-US', {style: 'currency', currency: 'USD'});
    return;
};

onMounted(async () => {
   getProducts();
});

const getProducts = async () => {
    try {
        const [productsResponse, categoriesResponse] = await Promise.all([
            axios.get('http://127.0.0.1:8000/api/getProducts'),
            axios.get('http://127.0.0.1:8000/api/getCategory'),
        ]);
        products.value = productsResponse.data.map(product => ({
            ...product,
            categoryName: '',
        }));
        categories.value = categoriesResponse.data;
        mapCategoryNamesToProducts();
    } catch (error) {
        console.error('Axios İstek Hatası:', error);
    }
}
const mapCategoryNamesToProducts = () => {
    products.value.forEach(product => {
        const categoryId = product.category_id;
        const matchingCategory = categories.value.find(category => category.id === categoryId);
        if (matchingCategory) {
            product.categoryName = matchingCategory.name; // categoryName'yi matchingCategory'nin name özelliği ile güncelle
        }
    });
};
const deleteProduct = () => {
    const productId  = product.value.id;
    axios.delete(`http://127.0.0.1:8000/api/deleteProduct/${productId}`)
        .then(response => {
            console.log(response)
        });
    getProducts();
    deleteProductDialog.value = false;
};
const confirmDeleteProduct = (prod) => {
    product.value = prod;
    deleteProductDialog.value = true;
};
const confirmDeleteSelected = () => {

    selectedProductsToDelete.value = [...selectedProducts.value];
    deleteSelectedProducts(selectedProductsToDelete.value);

};
const deleteSelectedProducts = (data) => {
    const productIdsToDelete = data.map(product => product.id);

    axios.delete('http://127.0.0.1:8000/api/bulkDelete', {
        data: {
            ids: productIdsToDelete
        }
    })
        .then(response => {
            console.log('Silme işlemi başarıyla tamamlandı:', response.data);
            getProducts();
        })
        .catch(error => {
            console.error('Silme işlemi sırasında bir hata oluştu:', error.response.data);
        })
        .finally(() => {
            getProducts();
        });
};








const openNew = () => {
    product.value = {};
    submitted.value = false;
    productDialog.value = true;
};
const hideDialog = () => {
    productDialog.value = false;
    submitted.value = false;
};
const saveProduct = () => {
    submitted.value = true;

    if (product.value.name.trim()) {
        if (product.value.id) {
            product.value.inventoryStatus = product.value.inventoryStatus.value ? product.value.inventoryStatus.value : product.value.inventoryStatus;
            products.value[findIndexById(product.value.id)] = product.value;
            toast.add({severity:'success', summary: 'Successful', detail: 'Product Updated', life: 3000});
        }
        else {
            product.value.id = createId();
            product.value.code = createId();
            product.value.image = 'product-placeholder.svg';
            products.value.push(product.value);
            toast.add({severity:'success', summary: 'Successful', detail: 'Product Created', life: 3000});
        }

        productDialog.value = true;
        product.value = {};

    }

};
const editProduct = (prod) => {
    product.value = {...prod};
    productDialog.value = true;
};

const findIndexById = (id) => {
    let index = -1;
    for (let i = 0; i < products.value.length; i++) {
        if (products.value[i].id === id) {
            index = i;
            break;
        }
    }
    return index;
};

const exportCSV = () => {
    dt.value.exportCSV();
};





</script>

