<template>
    <el-button v-model="isCollapse" @click="store.toggleCollapse()" style="margin-bottom: 20px">
        <el-icon v-if="store.isCollapsed"><Expand/></el-icon>
        <el-icon v-else><Fold/></el-icon>
    </el-button>
    <el-menu
        class="el-menu-vertical-demo"
        :collapse="store.isCollapsed"
        @open="handleOpen"
        @close="handleClose"
    >
        <el-menu-item index="1" @click="$router.push({name : 'customers'})">
            <el-icon><Bowl /></el-icon>
            <template #title>Customer</template>
        </el-menu-item>
        <el-menu-item index="2" @click="$router.push({name : 'rooms'})">
            <el-icon><House /></el-icon>
            <template #title>Room</template>
        </el-menu-item>
        <el-menu-item index="3" @click="$router.push({name : 'reservations'})">
            <el-icon><document /></el-icon>
            <template #title>Reservation</template>
        </el-menu-item>
        <el-menu-item index="4" @click="$router.push({name : 'staffs'})">
            <el-icon><User /></el-icon>
            <template #title>Staff</template>
        </el-menu-item>
        <el-menu-item index="5" @click="$router.push({name : 'payments'})">
            <el-icon><Wallet /></el-icon>
            <template #title>Payment</template>
        </el-menu-item>
    </el-menu>
</template>

<script  setup>
import {computed, ref } from 'vue';
import {useRouter} from "vue-router";
import {useSidebarCollapseStore} from '../../stores/modules/sidebarCollapse.js';
import {
    Document, Expand, Fold,User,House,Wallet,Bowl
} from '@element-plus/icons-vue'

const store = useSidebarCollapseStore();
const isCollapse = ref(store.isCollapsed);
const router = useRouter();
</script>

<style>
.el-menu-vertical-demo:not(.el-menu--collapse) {
    width: 200px;
    min-height: 400px;
}
</style>
