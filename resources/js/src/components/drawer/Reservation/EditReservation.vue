<script setup>
import getReservation from '../../../services/reservation/getReservation.js';
import getVacantRoomsList from '../../../services/room/getVacantRoomsList.js';
import {useRoute} from "vue-router";
import getRoomsList from '../../../services/room/getRoomsList.js';
import getCustomersList from '../../../services/customer/getCustomersList.js';
import putReservation from '../../../services/reservation/putReservation.js';
import {ref} from "vue";

const {vacantRoomsList, loadVacantRoomsList} = getVacantRoomsList();
const {updateReservation, updateLoadingButton} = putReservation();
const {roomsList, loadRoomsList} = getRoomsList();
const {customersList, loadCustomersList} = getCustomersList();
const route = useRoute();
const {reservation, loadReservation} = getReservation();
const openReservationEditDrawer = defineModel();
const props = defineProps(['reservationId']);
const emits = defineEmits(['content-updated']);
const formRef = ref(null);
const handleOpenDrawer = () => {
    loadRoomsList();
    loadVacantRoomsList();
    loadCustomersList();
    loadReservation(props.reservationId);
}
const handleSubmit = (formEl) => {
    const reservationUpdated = {
        id: props.reservationId,
        room_id: reservation.value.room_id_new,
        room_id_previous: reservation.value.room_id,
        customer_id: reservation.value.customer_id,
        check_in_date: reservation.value.check_in_date,
        check_out_date: reservation.value.check_out_date,
    };
    formEl.validate((valid) => {
        if (valid) updateReservation(reservationUpdated)
            .then(() => {
                openReservationEditDrawer.value = false;
                emits('content-updated');
            }).catch((err) => {
                console.log(err);
            })
    }).catch();
}
</script>

<template>
    <el-drawer
        v-model="openReservationEditDrawer"
        title="Edit Reservation"
        direction="rtl"
        @open="handleOpenDrawer()"
    >
        <el-form label-position="top" ref="formRef" :model="reservation">

            <el-form-item prop="room_id_new" label="Room Number"
            >
                <el-select
                    v-model="reservation.room_id_new"
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
                    v-model="reservation.customer_id"
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
                    v-model="reservation.check_in_date"
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
                    v-model="reservation.check_out_date"
                    type="date"
                    placeholder="Check Out Date"
                    size="small"
                    format="YYYY/MM/DD"
                    value-format="YYYY-MM-DD"
                />
            </el-form-item>
            <el-form-item>
                <el-button :loading="updateLoadingButton" type="primary" size="small" @click="handleSubmit(formRef)">
                    Update
                </el-button>
            </el-form-item>
        </el-form>
    </el-drawer>
</template>

<style scoped>

</style>
