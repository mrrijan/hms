<script setup>
    import getStaff from '../../../services/staff/getStaff.js';
    import putStaff from '../../../services/staff/putStaff.js';
    import {reactive, ref} from 'vue';

    const {staff , loadStaff} = getStaff();
    const {updateStaff,updateLoadingButton} = putStaff();
    const emits = defineEmits(['content-updated']);
    const props = defineProps(['staffId']);

    const editStaffDrawer = defineModel();
    const formRef=ref(false);
    const handleSubmit = (formEl)=>{
        const updatedStaff = {
            id : props.staffId,
            name : staff.value.name,
            role : staff.value.role,
            shift : staff.value.shift,
            phone : staff.value.phone,
        }
        formEl.validate((valid)=>{
            if(valid) updateStaff(updatedStaff)
                .then(()=>{
                    editStaffDrawer.value = false;
                    emits('content-updated');
                }).catch((err)=>{
                    console.log(err);
                })
        }).catch();
    }
    const validatePhoneNo = (rule , value , callback)=>{
        if(staff.value.phone.length  != 10) callback(new Error('Invalid Phone No'));
        return true;
    }
    const rules = reactive({
        phone : [{validator : validatePhoneNo ,trigger : 'blur'}]
    })
</script>

<template>
    <el-drawer
        v-model="editStaffDrawer"
        title="Edit Staff"
        direction="rtl"
        @open="loadStaff(staffId)"
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
                <el-button :loading="updateLoadingButton" type="primary" @click="handleSubmit(formRef)">Update</el-button>
            </el-form-item>
        </el-form>
    </el-drawer>
</template>

<style scoped>

</style>
