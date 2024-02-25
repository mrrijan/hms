<script setup>
import getStaffs from '../../../services/staff/getStaffs.js';
import deleteStaff from '../../../services/staff/deleteStaff.js';
import {useRouter,useRoute} from "vue-router";
import {onMounted , ref ,watch} from "vue";
import AddStaff from "../../../components/drawer/Staff/AddStaff.vue";
import {Delete, Edit, Search} from "@element-plus/icons-vue";
import EditStaff from "../../../components/drawer/Staff/EditStaff.vue";
import Pagination from "../../../components/Pagination.vue";

const searchTerm = ref('');
const router = useRouter();
const route = useRoute();
const {staffs,meta,loadStaffs,staffsLoading} = getStaffs();
const {destroyStaff , deleteLoadingButton} = deleteStaff();
const addStaffDrawer = ref(false);
const editStaffDrawer = ref(false);
const staffId = ref(0);
let searchTimeout;

onMounted(()=>{
    loadStaffs(route.fullPath);
})
const contentUpdated = ()=>{
    loadStaffs(route.fullPath);
}
const handleDelete = (staff_id)=>{
    destroyStaff(staff_id)
        .then(()=>{
            loadStaffs(route.fullPath);
        }).catch((err)=>{
            console.log(err);
    })
}
watch(route,(oldValue,newValue)=>{
    if(route.name === 'staffs') loadStaffs(route.fullPath);
})

const searchStaff = ()=>{
    if(searchTerm.value !== '') router.push({name : 'staffs' , query : {search_term : searchTerm.value}});
    else router.push({name : 'staffs'});
}
watch(searchTerm , (oldValue , newValue) =>{
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(searchStaff,500);
})
</script>

<template>
    <el-row>
        <el-col :span="18">
            <el-button type="primary" size="small" @click="addStaffDrawer = true">Add Staff</el-button>
        </el-col>
        <el-col :span="6">
            <el-input keyup.enter="searchCustomers" :prefix-icon="Search" size="small" clearable placeholder="search" v-model="searchTerm"/>
        </el-col>
    </el-row>
    <el-table v-model="staffsLoading"  :data="staffs" style="width : 100%" border>
        <el-table-column prop="name" label="Name"/>
        <el-table-column prop="role" label="Role"/>
        <el-table-column prop="shift" label="Shift"/>
        <el-table-column prop="phone" label="Phone"/>
        <el-table-column label="Actions">
            <template #default="scope">
                <el-button type="primary" :icon="Edit"
                           size="small" @click="editStaffDrawer = true ;staffId = scope.row.id; "/>
                <el-popconfirm title="Delete?" confirm-button-text="yes" cancel-button-text="No"
                               @confirm="handleDelete(scope.row.id)">
                    <template #reference>
                        <el-button :loading="deleteLoadingButton" type="danger" :icon="Delete" size="small"/>
                    </template>
                </el-popconfirm>
            </template>
        </el-table-column>
    </el-table>
    <pagination :meta="meta" routeName="staffs"/>
    <AddStaff v-model="addStaffDrawer" @content-updated="contentUpdated"/>
    <EditStaff v-model="editStaffDrawer" :staffId = "staffId" @content-updated="contentUpdated"/>
</template>

<style scoped>

</style>
