<script setup>
import postPayment from '../../../services/payment/postPayment.js';
import getCustomersList from '../../../services/customer/getCustomersList.js';
import {ref , reactive} from "vue";

const {customersList , loadCustomersList} = getCustomersList();
const {addPayment,addLoadingButton} = postPayment();

const openPaymentAddDrawer = defineModel();
const emits = defineEmits(['content-updated']);

const value = ref('');
const formRef =  ref(null);
const paymentForm = reactive({
    customer_id : '',
    total_amount : 0,
    advance_payment : 0,
    payment_type : '',
    bill_no : '',
});

const handleReset = ()=>{
    paymentForm.customer_id = '';
    paymentForm.total_amount = 0;
    paymentForm.advance_payment = 0;
    paymentForm.payment_type = '';
    paymentForm.bill_no = '';
}
const handleOpenDrawer = ()=>{
    loadCustomersList();
    handleReset();
}
const handleSubmit = (formEl)=>{
    formEl.validate((valid)=>{
        if(valid)addPayment(paymentForm).then(()=>{
            openPaymentAddDrawer.value = false;
            emits('content-updated');
        }).catch((err)=>{
            console.log(err);
        });
    }).catch();
}
</script>

<template>
    <el-drawer
        v-model="openPaymentAddDrawer"
        title="Add Payment"
        direction="rtl"
        @open="handleOpenDrawer()"
    >
        <el-form :model="paymentForm" label-position="top" size="small" ref="formRef">
            <el-form-item prop="customer_id" :rules="[{required : true, message : 'Please select a customer name'}]">
                <el-select
                    v-model="paymentForm.customer_id"
                    class="m-2"
                    placeholder="Customer"
                    size="small"
                    style="width: 240px"
                    clearable
                >
                    <el-option
                        v-for="customer in customersList"
                        :key="customer.id"
                        :label="customer.name"
                        :value="customer.id"
                    />
                </el-select>
            </el-form-item>
            <el-form-item prop="total_amount" label="Total Amount" :rules="[{required : true,message : 'Please enter total amount'}]">
                <el-input-number v-model="paymentForm.total_amount"/>
            </el-form-item>
            <el-form-item prop="advance_payment" label="Advance Amount">
                <el-input-number v-model="paymentForm.advance_payment"/>
            </el-form-item>
            <el-form-item prop="payment_type" label="Payment Type" :rules="[{required : true , message : 'Please enter payment type'}]">
                <el-input v-model="paymentForm.payment_type" clearable/>
            </el-form-item>
            <el-form-item prop="bill_no" label="Bill_no" :rules="[{required : true , message : 'Please enter bill no'}]">
                <el-input v-model="paymentForm.bill_no" clearable/>
            </el-form-item>
            <el-form-item>
                <el-button @click="handleSubmit(formRef)" :loading="addLoadingButton" type="primary" size="small">Create</el-button>
            </el-form-item>
        </el-form>
    </el-drawer>
</template>

<style scoped>

</style>
