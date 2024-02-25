<script setup>
import getPayment from '../../../services/payment/getPayment.js';
import getCustomersList from '../../../services/customer/getCustomersList.js';
import putPayment from '../../../services/payment/putPayment.js';
import {ref} from "vue";

const {updatePayment,updateLoadingButton} = putPayment();
const {customersList , loadCustomersList} = getCustomersList();
const {payment , loadPayment} = getPayment();
const editPaymentDrawer = defineModel();
const emits = defineEmits(['content-updated']);
const props = defineProps(['paymentId']);
const formRef = ref(null);

const handleOpenDrawer = ()=>{
    loadPayment(props.paymentId);
    loadCustomersList();
}
const handleSubmit = (formEl)=>{
    const paymentUpdatedData = {
        id : props.paymentId,
        customer_id : payment.value.customer_id,
        total_amount : payment.value.total_amount,
        advance_payment : payment.value.advance_payment,
        payment_type : payment.value.payment_type,
        bill_no : payment.value.bill_no
    }
    formEl.validate((valid)=>{
        if(valid) updatePayment(paymentUpdatedData)
            .then(()=>{
                editPaymentDrawer.value = false;
                emits('content-updated');
            }).catch((err)=>{
                console.log(err);
            })
    }).catch();
}
</script>

<template>
    <el-drawer
        v-model="editPaymentDrawer"
        title="Edit Payment"
        direction="rtl"
        @open="handleOpenDrawer()"
    >
        <el-form :model="payment" label-position="top" size="small" ref="formRef">
            <el-form-item prop="customer_id" :rules="[{required : true, message : 'Please select a customer name'}]">
                <el-select
                    v-model="payment.customer_id"
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
                <el-input-number v-model="payment.total_amount"/>
            </el-form-item>
            <el-form-item prop="advance_payment" label="Advance Amount">
                <el-input-number v-model="payment.advance_payment"/>
            </el-form-item>
            <el-form-item prop="payment_type" label="Payment Type" :rules="[{required : true , message : 'Please enter payment type'}]">
                <el-input v-model="payment.payment_type" clearable/>
            </el-form-item>
            <el-form-item prop="bill_no" label="Bill_no" :rules="[{required : true , message : 'Please enter bill no'}]">
                <el-input v-model="payment.bill_no" clearable/>
            </el-form-item>
            <el-form-item>
                <el-button :loading="updateLoadingButton" @click="handleSubmit(formRef)" type="primary" size="small">Update</el-button>
            </el-form-item>
        </el-form>
    </el-drawer>
</template>

<style scoped>

</style>
