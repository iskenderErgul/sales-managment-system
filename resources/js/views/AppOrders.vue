<template>
    <div class="card p-fluid">
        <Toolbar class="mb-4">
            <template #start>
                <Button label="New" icon="pi pi-plus" severity="success" disabled class="mr-2" />
                <Button label="Export" icon="pi pi-upload" severity="help" disabled       />
            </template>

        </Toolbar>

        <DataTable  :value="orders" editMode="row" dataKey="id"



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
                    <Dropdown v-model="data[field]" :options="statuses" optionLabel="label" optionValue="value" placeholder="Select a Status" style="width: 100%">
                        <template #option="slotProps">
                            <Tag :value="slotProps.option.value" :severity="getStatusLabel(slotProps.option.value)" style="font-size: 14px;" />
                        </template>
                    </Dropdown>
                </template>
                <template #body="slotProps">
                    <Tag :value="slotProps.data.order_status" :severity="getStatusLabel(slotProps.data.order_status)" style="font-size: 14px;" />
                </template>
            </Column>

            <Column  style="width: 10%; min-width: 8rem" bodyStyle="text-align:center">
                <template #body="slotProps">
                    <Button label="Orderitems" icon="pi pi-info-circle" class="p-button-rounded p-button-text"  @click="openOrderItemsDialog(slotProps.data, slotProps.$index)" />
                </template>
            </Column>
        </DataTable>

        <Dialog v-model:visible="orderItemsDialog" :style="{ width: '450px' }" header="Sipariş Detayları" :modal="true" class="p-fluid">
            <div v-if="selectedOrderItems.length > 0">
                <div v-for="orderItem in selectedOrderItems" :key="orderItem.id" class="field">
                    <label :for="`orderItemId-${orderItem.id}`" class="mb-3">Sipariş Detay ID</label>
                    <InputText :id="`orderItemId-${orderItem.id}`" v-model="orderItem.id" readonly />

                    <label :for="`orderItemOrderId-${orderItem.id}`" class="mb-3">Sipariş ID</label>
                    <InputText :id="`orderItemOrderId-${orderItem.id}`" v-model="orderItem.order_id" readonly />

                    <label :for="`orderItemProductId-${orderItem.id}`" class="mb-3">Ürün ID</label>
                    <InputText :id="`orderItemProductId-${orderItem.id}`" v-model="orderItem.product_id" readonly />

                    <label :for="`orderItemQuantity-${orderItem.id}`" class="mb-3">Miktar</label>
                    <InputText :id="`orderItemQuantity-${orderItem.id}`" v-model="orderItem.quantity" readonly />

                    <label :for="`orderItemUnitPrice-${orderItem.id}`" class="mb-3">Birim Fiyat</label>
                    <InputText :id="`orderItemUnitPrice-${orderItem.id}`" v-model="orderItem.unit_price" readonly />

                    <label :for="`orderItemTotalPrice-${orderItem.id}`" class="mb-3">Toplam Fiyat</label>
                    <InputText :id="`orderItemTotalPrice-${orderItem.id}`" v-model="orderItem.total_price" readonly />
                </div>
            </div>
            <template #footer>
                <Button label="Kapat" icon="pi pi-times" text @click="closeOrderItemsDialog" />
            </template>
        </Dialog>


    </div>
</template>

<script setup>
import { ref,onMounted } from 'vue';
import axios from "axios";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dropdown from 'primevue/dropdown';
import Tag from 'primevue/tag';
import InputText from 'primevue/inputtext';
import Toolbar from "primevue/toolbar";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
let selectedOrderItems = ref([]);
const orderItemsDialog = ref(false);
const orders = ref([

]);

const getStatusLabel = (status) => {
    switch (status) {
        case 'Hazırlık':
            return 'success';

        case 'Kargoda':
            return 'warning';

        case 'Teslim Edildi':
            return 'danger';

        default:
            return null;
    }
};

onMounted(() => {
    getOrders();
});

const getOrders = async () => {
    try {
        const resp = await axios.get('http://127.0.0.1:8000/api/getOrders');
        orders.value = resp.data;
    } catch (errors) {
        console.error(errors);
    }
}
const closeOrderItemsDialog = () => {
    orderItemsDialog.value=false;
}
const openOrderItemsDialog = (selectedOrder) => {
    orderItemsDialog.value=true;
    selectedOrderItems.value = selectedOrder.order_items;
}


</script>





