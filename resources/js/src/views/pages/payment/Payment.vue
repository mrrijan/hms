<script setup>
import getPayments from '../../../services/payment/getPayments.js';
import {useRoute} from "vue-router";
import {onMounted, ref, computed, watch} from "vue";
import AddPayment from "../../../components/drawer/payment/AddPayment.vue";
import {Delete, Edit, Search} from "@element-plus/icons-vue";
import EditPayment from "../../../components/drawer/payment/EditPayment.vue";
import deletePayment from '../../../services/payment/deletePayment.js';
import {useRouter} from "vue-router";
import Pagination from "../../../components/Pagination.vue";

const router = useRouter();
const {destroyPayment,deleteLoadingButton} =deletePayment();
const {payments, loadPayments , meta , paymentsLoading} = getPayments();
const route = useRoute();
onMounted(() => {
    loadPayments(route.fullPath);
})
const openPaymentAddDrawer = ref(false);
const contentUpdated = ()=>{
    loadPayments(route.fullPath);
}
const editPaymentDrawer = ref(false);
const paymentId = ref(0);

const handleDelete = (payment_id)=>{
    destroyPayment(payment_id).then(()=>{
        loadPayments(route.fullPath);
    }).catch((err)=>{
        console.log(err);
    });
}
const searchTerm = ref('');
const searchPayment = ()=>{
    if(searchTerm.value !== '') router.push({name : 'payments' , query : {search_term : searchTerm.value}});
    else router.push({name : 'payments'});
}
let searchTimeout;
watch(searchTerm,(oldValue , newValue)=>{
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(searchPayment,500);
})
watch(route , (oldValue , newValue)=>{
    if(route.name === 'payments') loadPayments(route.fullPath);
})
</script>

<template>
    <el-row>
        <el-col :span="18">
            <el-button type="primary" size="small" @click="openPaymentAddDrawer = true;">Add Payment</el-button>
        </el-col>
        <el-col :span="6">
            <el-input  size="small" keyup.enter="searchCustomers" :prefix-icon="Search" placeholder="search" v-model="searchTerm" clearable/>
        </el-col>
    </el-row>
    <el-table v-loading="paymentsLoading" :data="payments">
        <el-table-column prop="customer_name" label="Customer"/>
        <el-table-column prop="total_amount" label="Total Amount"/>
        <el-table-column prop="advance_payment" label="Advance Payment"/>
        <el-table-column label="Remaining amount" width="150">
            <template #default="scope">
                {{scope.row.total_amount - scope.row.advance_payment}}
            </template>
        </el-table-column>
        <el-table-column prop="payment_type" label="Payment Type"/>
        <el-table-column prop="bill_no" label="Bill No."/>
        <el-table-column label="Actions">
            <template #default="scope">
                <el-button type="primary" :icon="Edit" @click="editPaymentDrawer = true; paymentId = scope.row.id "
                           size="small" :loading="deleteLoadingButton"/>
                <el-popconfirm title="Delete?" confirm-button-text="yes" cancel-button-text="No"
                               @confirm="handleDelete(scope.row.id)" >
                    <template #reference>
                        <el-button type="danger" :icon="Delete" size="small"/>
                    </template>
                </el-popconfirm>
            </template>
        </el-table-column>
    </el-table>
    <pagination :meta="meta" routeName="payments"/>
    <AddPayment v-model="openPaymentAddDrawer" @content-updated="contentUpdated"/>
    <EditPayment v-model="editPaymentDrawer" @content-updated="contentUpdated" :paymentId="paymentId"/>
</template>

<style scoped>

</style>
