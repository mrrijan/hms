<script setup>
import getCustomer from '../../../services/customer/getCustomer.js'
import putCustomer from '../../../services/customer/putCustomer.js';
import {ref} from 'vue';

const {updateCustomer,updateLoadingButton} = putCustomer();
const formRef = ref(null);
const editDrawer = defineModel();
const props = defineProps(['customerId']);

const emit = defineEmits(['content-updated']);

const {customer, loadCustomer} = getCustomer()
const handleSubmit = (formRef) => {
    const customerData = {
        id: props.customerId,
        name: customer.value.name,
        age: customer.value.age,
        address: customer.value.address,
        citizenship_no: customer.value.citizenship_no,
        phone_no: customer.value.phone_no
    }
    formRef.validate((valid) => {
        if (valid) updateCustomer(customerData).then(() => {
                emit('content-updated');
                editDrawer.value = false;
            }
        ).catch();
    }).catch();
}

</script>

<template>
    <el-drawer
        v-model="editDrawer"
        title="Edit Customer"
        direction="rtl"
        @open="loadCustomer(customerId)"
    >
        <el-form :rules="rules" :model="customer" ref="formRef" label-position="top" size="small">
            <el-form-item label="Name" prop="name" :rules="[{required: true, message :'Enter Customer Name'}]" required>
                <el-input v-model="customer.name" clearable></el-input>
            </el-form-item>
            <el-form-item label="Age" prop="age">
                <el-input-number v-model="customer.age"></el-input-number>
            </el-form-item>
            <el-form-item label="Address" prop="address" :rules="[{required: true, message :'Enter Customer Address'}]"
                          required>
                <el-input v-model="customer.address" clearable></el-input>
            </el-form-item>
            <el-form-item label="Citizenship" prop="citizenship_no"
                          :rules="[{required: true, message :'Enter Citizenship_no'}]" required>
                <el-input v-model="customer.citizenship_no" clearable></el-input>
            </el-form-item>
            <el-form-item label="Phone" prop="phone_no">
                <el-input type="number" v-model="customer.phone_no"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="handleSubmit(formRef)" :loading="updateLoadingButton">Update</el-button>
            </el-form-item>
        </el-form>
    </el-drawer>
</template>

<style scoped>

</style>
