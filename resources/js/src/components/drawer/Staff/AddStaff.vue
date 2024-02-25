<script setup>
import {reactive, ref} from 'vue';
import postStaff from '../../../services/staff/postStaff.js';

const emits = defineEmits(['content-updated']);
const {addStaff,addLoadingButton} = postStaff();
const formRef = ref(null);
const staff = reactive({
    name : '',
    role : '',
    shift : '',
    phone : 0,
})
const addStaffDrawer = defineModel();
const handleSubmit = (formEl)=>{
    const staffDetails = {
        name : staff.name,
        role : staff.role,
        shift : staff.shift,
        phone : staff.phone,
    };
        formEl.validate((valid)=>{
            if(valid) addStaff(staffDetails).then(()=>{
                addStaffDrawer.value = false;
                emits('content-updated');
            }).catch((err)=>{
                console.log(err);
            })
        }).catch();
}
const resetFields = ()=>{
    staff.name = '';
    staff.role = '';
    staff.shift = '';
    staff.phone = 0;
}
const validatePhoneNo = (rule , value , callback)=>{
    if(staff.phone.length != 10) callback(new Error('Invalid Phone No'));
    return true;
}
const rules = reactive({
    phone : [{validator : validatePhoneNo ,trigger : 'blur'}],
})
</script>

<template>
    <el-drawer
        v-model="addStaffDrawer"
        title="Add Staff"
        direction="rtl"
        @open = "resetFields"
    >
        <el-form :rules="rules" :model="staff" ref="formRef" label-position="top" size="small">
            <el-form-item prop="name" label="Name" :rules="[{required : true , message : 'Please enter the Name'}]">
                <el-input v-model="staff.name" clearable/>
            </el-form-item>
            <el-form-item prop="role" label="Role" :rules="[{required : true , message : 'Please enter the Role'}]">
                <el-input v-model="staff.role" clearable/>
            </el-form-item>
            <el-form-item prop="shift" label="Shift" :rules="[{required : true , message : 'Please enter the Shift'}]">
                <el-input v-model="staff.shift" clearable/>
            </el-form-item>
            <el-form-item prop="phone" label="Phone" :rules="[{required : true , message : 'Please enter the Phone'}]">
                <el-input type="number" v-model="staff.phone"/>
            </el-form-item>
            <el-form-item>
                <el-button :loading="addLoadingButton" type="primary" @click="handleSubmit(formRef)">Create</el-button>
            </el-form-item>
        </el-form>
    </el-drawer>
</template>

<style scoped>

</style>
