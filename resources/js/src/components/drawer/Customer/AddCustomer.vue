<script setup>
import {onMounted, reactive, ref, watch} from "vue";
import postCustomer from '../../../services/customer/postCustomer.js';
import getCustomers from '../../../services/customer/getCustomers.js';

const emit = defineEmits(['content-updated']);

const formRef = ref(null);
const {loadCustomers} = getCustomers();
const {addCustomer,addCustomerLoading} = postCustomer();
const AddCustomerData = reactive({
    name: '',
    age: 1,
    address: '',
    citizenship_no: '',
    phone_no: ''
});
const drawer = defineModel();
const handleSubmit = (formRef) => {
    const customer = {
        name: AddCustomerData.name,
        age: AddCustomerData.age,
        address: AddCustomerData.address,
        citizenship_no: AddCustomerData.citizenship_no,
        phone_no: AddCustomerData.phone_no
    }
    formRef.validate((valid) => {
        if (valid) addCustomer(customer)
            .then(() => {
                drawer.value = false;
                emit('content-updated');
            })
            .catch((err) => {
                console.log(err);
            })
    }).catch();
}

const resetFields = () => {
    AddCustomerData.name = ''
    AddCustomerData.age = 1;
    AddCustomerData.address = ''
    AddCustomerData.citizenship_no = ''
    AddCustomerData.phone_no = ''
}
const validatePhoneNo = (rule, value, callback) => {
    if (AddCustomerData.phone_no.length != 10) callback(new Error('Invalid phone no.'));
    return true;
};
const validateAge = (rule, value, callback) => {
    if (!value) callback(new Error('Age cannot be empty'));
    if (value === null) callback(new Error('Age cannot be empty'));
    if (value < 16) callback(new Error('Not of Valid Age'));
    return true;

}
const rules = reactive({
    phone_no: [{validator: validatePhoneNo, trigger: 'blur'}],
    age: [{validator: validateAge, trigger: 'blur'}],

})

</script>
<template>
    <el-drawer
        v-model="drawer"
        title="Add Customer"
        direction="rtl"
        @open="resetFields"
    >
        <el-form :rules="rules" :model="AddCustomerData" ref="formRef" label-position="top" size="small">
            <el-form-item label="Name" prop="name" :rules="[{required: true, message :'Enter Customer Name'}]" required>
                <el-input v-model="AddCustomerData.name" clearable></el-input>
            </el-form-item>
            <el-form-item label="Age" prop="age">
                <el-input-number v-model="AddCustomerData.age"></el-input-number>
            </el-form-item>
            <el-form-item label="Address" prop="address" :rules="[{required: true, message :'Enter Customer Address'}]"
                          required>
                <el-input v-model="AddCustomerData.address" clearable></el-input>
            </el-form-item>
            <el-form-item label="Citizenship" prop="citizenship_no"
                          :rules="[{required: true, message :'Enter Citizenship_no'}]" required>
                <el-input v-model="AddCustomerData.citizenship_no" clearable></el-input>
            </el-form-item>
            <el-form-item label="Phone" prop="phone_no">
                <el-input type="number" v-model="AddCustomerData.phone_no"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="handleSubmit(formRef)" :loading="addCustomerLoading">Create</el-button>
            </el-form-item>
        </el-form>
    </el-drawer>
</template>
