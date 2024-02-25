<script setup>
import getReservations from '../../../services/reservation/getReservations.js';
import {useRouter,useRoute} from "vue-router";
import {onMounted , ref , watch} from "vue";
import AddReservation from "../../../components/drawer/Reservation/AddReservation.vue";
import {Delete, Edit, Search} from "@element-plus/icons-vue";
import EditReservation from "../../../components/drawer/Reservation/EditReservation.vue";
import deleteReservation from '../../../services/reservation/deleteReservation.js';
import Pagination from "../../../components/Pagination.vue";

const {destroyReservation , deleteLoadingButton} = deleteReservation();
const {reservations,meta,loadReservations ,reservationsLoading} = getReservations();
const route = useRoute();
const router = useRouter();
const openReservationDrawer = ref(false);
const openReservationEditDrawer = ref(false);
const reservationId = ref(0);
const searchTerm = ref('');
onMounted(()=>{
    loadReservations(route.fullPath);
})
const contentUpdated = ()=>{
    loadReservations(route.fullPath);
}
const handleDelete = (reservation_id)=>{
    destroyReservation(reservation_id).then(()=>{
        loadReservations(route.fullPath);
    }).catch((err)=>{
        console.log(err);
    });
}

const searchReservation = ()=>{
    if(searchTerm.value !== '') router.push({name : 'reservations',query : {search_term : searchTerm.value}});
    else router.push({name : 'reservations'});
}
let searchTimeout;
watch(searchTerm , (oldValue , newValue) =>{
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(searchReservation,500);
})
watch(route , (oldValue , newValue) =>{
    if(route.name === 'reservations') loadReservations(route.fullPath);
})
</script>

<template>
    <el-row>
        <el-col :span="18">
                <el-button type="primary" size="small" @click="openReservationDrawer = true;">Add Reservation</el-button>
        </el-col>
        <el-col :span="6">
                <el-input clearable keyup.enter="searchCustomers" :prefix-icon="Search" size="small" placeholder="search" v-model="searchTerm"/>
        </el-col>
    </el-row>
    <el-table v-loading="reservationsLoading" :data="reservations" style="width: 100%" border>
            <el-table-column prop="room_number" label="Room No."/>
            <el-table-column prop="customer_name" label="Customer Name"/>
            <el-table-column prop="check_in_date" label="Check In Date"/>
            <el-table-column prop="check_out_date" label="Check Out Date"/>
        <el-table-column label="Actions">
            <template #default="scope">
                <el-button type="primary" :icon="Edit" @click="openReservationEditDrawer = true; reservationId = scope.row.id "
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
    <pagination :meta="meta" routeName="reservations"/>
    <AddReservation v-model="openReservationDrawer" @content-updated="contentUpdated"/>
    <EditReservation v-model="openReservationEditDrawer" @content-updated="contentUpdated" :reservationId="reservationId"/>
</template>

<style scoped>

</style>
