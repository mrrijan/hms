<script setup>
import getRooms from '../../../services/room/getRooms.js';
import {onMounted, ref, watch, watchEffect} from "vue";
import {useRouter, useRoute} from "vue-router";
import {Delete, Edit, Search} from "@element-plus/icons-vue";
import AddRoom from "../../../components/drawer/Room/AddRoom.vue";
import EditRoom from "../../../components/drawer/Room/EditRoom.vue";
import deleteRoom from '../../../services/room/deleteRoom.js';
import Pagination from "../../../components/Pagination.vue";
import AddReservation from "../../../components/drawer/Reservation/AddReservation.vue";

const {destroyRoom, deleteLoadingButton} = deleteRoom();
const {meta, rooms, loadRooms, roomsLoading} = getRooms();
const router = useRouter();
const route = useRoute();
const addRoomDrawer = ref(false);
const editRoomDrawer = ref(false);
const roomId = ref(0);

const searchTerm = ref('');
let searchTimeout;
const searchRooms = () => {
    if (searchTerm.value !== '') router.push({name: 'rooms', query: {search_term: searchTerm.value}});
    else router.push({name: 'rooms'});
}
watch(searchTerm, (oldValue, newValue) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(searchRooms, 500);
})
watch(route, (oldValue, newValue) => {
    if (route.name === 'rooms') loadRooms(route.fullPath);
});

onMounted(() => {
    loadRooms(route.fullPath);
});
const contentUpdated = () => {
    loadRooms(route.fullPath);
}
const handleDelete = (room_id) => {
    destroyRoom(room_id).then(() => {
        loadRooms(route.fullPath);
    }).catch((err) => {
        console.log(err);
    })
}
const occupancyStatus = ref(0);
const handleChange = (value) => {
    switch (value) {
        case 2 :
            router.push({name: 'rooms', query: {...route.query, occupancy: value,}});
            break;
        case 1 :
            router.push({name: 'rooms', query: {...route.query, occupancy: value}});
            break;
        default :
            router.push({name: 'rooms', query: {...route.query, occupancy: value}})
    }
}
</script>

<template>
    <el-row>
        <el-col :span="12">
            <el-button type="primary" size="small" @click="addRoomDrawer = true;">Add Room</el-button>
        </el-col>
        <el-col :span="6">
            <el-select
                v-model="occupancyStatus"
                class="m-2"
                placeholder="Select"
                size="small"
                style="width: 240px"
                @change="handleChange"
                :style="{width : '200px'}"
            >
                <el-option :value="0" label="All"/>
                <el-option :value="2" label="Vacant"/>
                <el-option :value="1" label="Occupied"/>
            </el-select>
        </el-col>
        <el-col :span="6">
            <el-input placeholder="search" @keyup.enter="searchRooms" :prefix-icon="Search" size="small"
                      v-model="searchTerm" clearable></el-input>
        </el-col>
    </el-row>
    <el-table v-loading="roomsLoading" :data="rooms" border style="width: 100%">
        <el-table-column prop="room_number"
                         label="Room Number" width="180"/>
        <el-table-column prop="maximum_occupancy" label="Maximum Occupancy"/>
        <el-table-column label="Occupancy Status">
            <template #default="scope">
                <el-tag v-if="scope.row.occupancy_status === 0" type="success">Vacant</el-tag>
                <el-tag v-else type="danger">Occupied</el-tag>
            </template>
        </el-table-column>
        <el-table-column prop="number_of_beds" label="Number of beds"/>
        <el-table-column label="Actions">
            <template #default="scope">
                <el-button type="primary" :icon="Edit"
                           size="small" @click="editRoomDrawer = true ; roomId = scope.row.id "/>
                <el-popconfirm title="Delete?" confirm-button-text="yes" cancel-button-text="No"
                               @confirm="handleDelete(scope.row.id)">
                    <template #reference>
                        <el-button :loading="deleteLoadingButton" type="danger" :icon="Delete" size="small"/>
                    </template>
                </el-popconfirm>
            </template>
        </el-table-column>
    </el-table>
    <AddRoom v-model="addRoomDrawer" @content-updated="contentUpdated"/>
    <EditRoom v-model="editRoomDrawer" :roomId="roomId" @content-updated="contentUpdated"/>
    <pagination :meta="meta" routeName="rooms"/>
</template>

<style scoped>

</style>
