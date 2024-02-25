<script setup>
import getRoomsList from '../../../services/room/getRoomsList.js';
import getVacantRoomsList from '../../../services/room/getVacantRoomsList.js';
import {ref, onMounted, reactive} from 'vue';
import getCustomersList from '../../../services/customer/getCustomersList.js';
import postReservation from '../../../services/reservation/postReservation.js'

const {vacantRoomsList, loadVacantRoomsList} = getVacantRoomsList();
const {customersList, loadCustomersList} = getCustomersList();
// const {roomsList, loadRoomsList} = getRoomsList();
const {addReservation, addLoadingButton} = postReservation();
const emits = defineEmits(['content-updated']);

onMounted(() => {
    loadVacantRoomsList();
})
const openReservationDrawer = defineModel();

const reservationForm = reactive({
    room_id: '',
    customer_id: '',
    check_in_date: '',
    check_out_date: '',
});
const formRef = ref(null);
const handleSubmit = (formEl) => {
    console.log(reservationForm);
    formEl.validate((valid) => {
        if (valid) addReservation(reservationForm)
            .then(() => {
                openReservationDrawer.value = false;
                emits('content-updated');
            }).catch((err) => {
                console.log(err);
            })
    }).catch();
}
const resetFields = () => {
    reservationForm.room_id = '';
    reservationForm.customer_id = '';
    reservationForm.check_in_date = '';
    reservationForm.check_out_date = '';
}
const handleOpenDrawer = () => {
    resetFields();
    loadVacantRoomsList();
    loadCustomersList();
}
</script>

<template>
    <el-drawer
        v-model="openReservationDrawer"
        title="Add Reservation"
        direction="rtl"
        @open="handleOpenDrawer()"
    >
        <el-form label-position="top" ref="formRef" :model="reservationForm">
            <el-form-item prop="room_id" label="Room Number"
                          :rules="[{required : true , message : 'Please select a room'}]">
                <el-select
                    v-model="reservationForm.room_id"
                    class="m-2"
                    placeholder="Select Room Number"
                    style="width: 240px"
                    filterable
                    clearable
                >
                    <el-option
                        v-for="room in vacantRoomsList"
                        :key="room.id"
                        :label="room.room_number"
                        :value="room.id"
                    />
                </el-select>
            </el-form-item>
            <el-form-item prop="customer_id" label="Customer"
                          :rules="[{required : true , message : 'Please select a Customer'}]">
                <el-select
                    v-model="reservationForm.customer_id"
                    class="m-2"
                    placeholder="Select Customer Name"
                    style="width: 240px"
                    filterable
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
            <el-form-item prop="check_in_date" label="Check In Date"
                          :rules="[{required : true , message : 'Please select a date'}]">
                <el-date-picker
                    v-model="reservationForm.check_in_date"
                    type="date"
                    placeholder="Check In Date"
                    size="small"
                    format="YYYY/MM/DD"
                    value-format="YYYY-MM-DD"
                />
            </el-form-item>
            <el-form-item prop="check_out_date" label="Check Out Date"
                          :rules="[{required : true , message : 'Please select a date'}]">
                <el-date-picker
                    v-model="reservationForm.check_out_date"
                    type="date"
                    placeholder="Check Out Date"
                    size="small"
                    format="YYYY/MM/DD"
                    value-format="YYYY-MM-DD"
                />
            </el-form-item>
            <el-form-item>
                <el-button type="primary" :loading="addLoadingButton" @click="handleSubmit(formRef)">Create</el-button>
            </el-form-item>
        </el-form>
    </el-drawer>
</template>

<style scoped>

</style>
