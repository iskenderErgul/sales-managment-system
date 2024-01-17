<template>
    <div class="card p-fluid">
        <Toolbar class="mb-4">
            <template #start>
                <Button label="New" icon="pi pi-plus" severity="success" class="mr-2" @click="openNew" />
                <Button label="Export" icon="pi pi-upload" severity="help" @click="exportCSV($event)"  />
            </template>

        </Toolbar>

        <DataTable v-model:editingRows="editingRows" :value="products" editMode="row" dataKey="id" @row-edit-save="onRowEditSave"
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
                    <h4 class="m-0">Manage Orders</h4>
                    <span class="p-input-icon-left"> </span>
                </div>
            </template>
            <Column field="id" header="OrderId" style="width: 20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" />
                </template>
            </Column>
            <Column field="user_id" header="UserId" style="width: 20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" />
                </template>
            </Column>
            <Column field="total_amount" header="Total Amount" style="width: 20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" />
                </template>
            </Column>
            <Column field="order_status" header="Status" style="width: 20%">
                <template #editor="{ data, field }">
                    <Dropdown v-model="data[field]" :options="statuses" optionLabel="label" optionValue="value" placeholder="Select a Status">
                        <template #option="slotProps">
                            <Tag :value="slotProps.option.value" :severity="getStatusLabel(slotProps.option.value)" />
                        </template>
                    </Dropdown>
                </template>
                <template #body="slotProps">
                    <Tag :value="slotProps.data.order_status" :severity="getStatusLabel(slotProps.data.order_status)" />
                </template>
            </Column>


            <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center"></Column>

            <Column  style="width: 10%; min-width: 8rem" bodyStyle="text-align:center">
                <template #body="slotProps">

                    <Button label="Orderitems" icon="pi pi-info-circle" class="p-button-rounded p-button-text" @click="openOrderItemsDialog(slotProps.data)" />
                </template>
            </Column>
        </DataTable>
        <Dialog v-model:visible="ordersDialog" :style="{width: '450px'}" header="New Order" :modal="true" class="p-fluid">
            <div class="field">
                <label for="user_id" class="mb-3">UserId</label>
                <InputText id="user_id" v-model="products.user_id" />
            </div>
            <div class="field">
                <label for="order_status" class="mb-3">Order Status</label>
                <Dropdown id="order_status" v-model="products.order_status" :options="statuses" optionLabel="label" placeholder="Select Order Status"/>
            </div>
            <template #footer>
                <Button label="Cancel" icon="pi pi-times" text @click="hideDialog"/>
                <Button label="Save" icon="pi pi-check" text @click="saveProduct" />
            </template>
        </Dialog>
        <Dialog v-model:visible="orderItemsDialog" :style="{ width: '450px' }" header="Order Items" :modal="true" class="p-fluid">
            <div class="field">
                <label for="orderId" class="mb-3">Order ID</label>
                <InputText id="orderId" v-model="selectedOrderItems.order_id" readonly />
            </div>
            <div class="field">
                <label for="productId" class="mb-3">Product ID</label>
                <InputText id="productId" v-model="selectedOrderItems.product_id" readonly />
            </div>
            <div class="field">
                <label for="quantity" class="mb-3">Quantity</label>
                <InputText id="quantity" v-model="selectedOrderItems.quantity" readonly />
            </div>
            <div class="field">
                <label for="unitPrice" class="mb-3">Unit Price</label>
                <InputText id="unitPrice" v-model="selectedOrderItems.unit_price" readonly />
            </div>
            <div class="field">
                <label for="totalPrice" class="mb-3">Total Price</label>
                <InputText id="totalPrice" v-model="selectedOrderItems.total_price" readonly />
            </div>
            <template #footer>
                <Button label="Close" icon="pi pi-times" text @click="closeOrderItemsDialog" />
            </template>
        </Dialog>

    </div>
</template>

<script setup>
import { ref } from 'vue';
const orderItemsDialog = ref(false);
const selectedOrderItems = ref('');

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dropdown from 'primevue/dropdown';
import Tag from 'primevue/tag';

import InputText from 'primevue/inputtext';
import Toolbar from "primevue/toolbar";
import Button from "primevue/button";

import RadioButton from "primevue/radiobutton";
import Dialog from "primevue/dialog";


const ordersDialog = ref(false);
const visible = ref(false);
const products = ref([
    {
        id: 1,
        user_id: '3',
        name: 'Product A',
        order_status: 'HAZIRLANIYOR',
        total_amount: 150.0,
        order_items : {
            order_id : 2,
            product_id : 6,
            quantity : 3,
            unit_price : 100,
            total_price : 300,
        },
    },
    {
        id: 2,
        user_id: '4',
        name: 'Product B',
        order_status: 'KARGODA',
        total_amount: 75.5,
        order_items : {
            order_id : 2,
            product_id : 6,
            quantity : 3,
            unit_price : 100,
            total_price : 300,
        },
    },
    {
        id: 3,
        user_id: '4',
        name: 'Product C',
        order_status: 'TESLİM EDİLDİ',
        total_amount: 75.5,
        order_items : {
            order_id : 2,
            product_id : 6,
            quantity : 3,
            unit_price : 100,
            total_price : 300,
        },
    },
]);
const editingRows = ref([]);
const statuses = ref([
    { label: 'Hazırlanıyor', value: 'HAZIRLANIYOR' },
    { label: 'Kargoda', value: 'KARGODA' },
    { label: 'Teslim Edildi', value: 'TESLİM EDİLDİ' },
]);

const onRowEditSave = (event) => {
    let { newData, index } = event;
    products.value[index] = newData;
};
const openNew = () => {
    ordersDialog.value = true;
};

const getStatusLabel = (status) => {
    switch (status) {
        case 'HAZIRLANIYOR':
            return 'success';

        case 'KARGODA':
            return 'warning';

        case 'TESLİM EDİLDİ':
            return 'danger';

        default:
            return null;
    }
};

const onEditClick = (rowData) => {

    editingRows.value = [rowData];
};

const openOrderItemsDialog = (rowData) => {

    selectedOrderItems.value = rowData.order_items;
    orderItemsDialog.value = true;
};

const closeOrderItemsDialog = () => {
    selectedOrderItems.value = '';
    orderItemsDialog.value = false;
};


</script>





