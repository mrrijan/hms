<script setup>
import getCustomers from "../../../services/customer/getCustomers.js";
import deleteCustomer from '../../../services/customer/deleteCustomer.js';
import {
    Delete,
    Edit,
    Search,
} from '@element-plus/icons-vue'
import {onMounted, ref, watchEffect, watch} from "vue";
import {useRouter, useRoute} from "vue-router";
import AddCustomer from "../../../components/drawer/Customer/AddCustomer.vue";
import EditCustomer from "../../../components/drawer/Customer/EditCustomer.vue";
import Pagination from "../../../components/Pagination.vue";

const {destroyCustomer,deleteLoadingButton} = deleteCustomer();
const route = useRoute();
const router = useRouter();
const {customers, loadCustomers, meta , customersLoading} = getCustomers();
onMounted(() => {
    loadCustomers(route.fullPath);
});
const drawer = ref(false);
const editDrawer = ref(false);
const customerId = ref(0)
const searchTerm = ref('');
let searchTimeout;

const searchCustomers = ()=>{
    if(searchTerm.value !== '') router.push({name : 'customers' , query : {search_term : searchTerm.value}})
    else router.push({name : 'customers'})
}


const contentUpdated = () => {
    loadCustomers();
}
watch(route, (oldValue, newValue) => {
    if (route.name === 'customers') loadCustomers(route.fullPath);
})

watch(searchTerm , (oldValue ,newValue) =>{
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(searchCustomers , 500);
})
const handleDelete = (id) => {
    destroyCustomer(id).then(() => {
        loadCustomers();
    }).catch((err) => {
        console.log(err)
    });
}

</script>
<template>
    <el-row>
        <el-col :span="18">
            <el-button type="primary" size="small" @click="drawer = true">Add Customer</el-button>
        </el-col>
        <el-col :span="6">
            <el-input size="small" v-model="searchTerm" @keyup.enter="searchCustomers" :prefix-icon="Search" placeholder="Search" clearable></el-input>
        </el-col>
    </el-row>

    <el-table v-loading="customersLoading"  :data="customers" style="width: 100%" border>
        <el-table-column prop="name" label="Name" width="180"/>
        <el-table-column prop="age" label="Age"/>
        <el-table-column prop="address" label="Address"/>
        <el-table-column prop="citizenship_no" label="Citizenship"/>
        <el-table-column prop="phone_no" label="Phone"/>
        <el-table-column label="Actions">
            <template #default="scope">
                <el-button type="primary" :icon="Edit" @click="editDrawer = true; customerId = scope.row.id "
                           size="small" />
                <el-popconfirm title="Delete?" confirm-button-text="yes" cancel-button-text="No"
                               @confirm="handleDelete(scope.row.id)">
                    <template #reference>
                        <el-button :loading="deleteLoadingButton" type="danger" :icon="Delete" size="small"/>
                    </template>
                </el-popconfirm>

            </template>
        </el-table-column>
    </el-table>
    <pagination :meta="meta" routeName="customers"/>
    <AddCustomer @content-updated="contentUpdated" v-model="drawer"/>
    <EditCustomer v-model="editDrawer" @content-updated="contentUpdated" :customerId="customerId"/>
</template>
<style scoped>

</style>
