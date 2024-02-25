<script setup>
import {ref, onMounted} from "vue";

const isOnline = ref(true);
const reloadPage = () => window.location.reload()
const checkOnlineStatus = () => isOnline.value = navigator.onLine;
onMounted(() => {
    checkOnlineStatus();
    window.addEventListener('online', checkOnlineStatus);
    window.addEventListener('offline', checkOnlineStatus);
})
</script>

<template>
    <el-alert title="No Internet Connection"
              v-if="!isOnline"
              type="error"
              effect="dark"
              @click="reloadPage"
              center show-icon />
    <router-view></router-view>
</template>

<style scoped>
.el-header {
    padding-left: 0;
    padding-right: 0;
}

.el-aside {
    width: auto;
    border-right: solid 1px var(--el-menu-border-color);
    min-height: 100vh;
}

.el-main {
    border-top: solid 1px var(--el-menu-border-color);
    padding-left: 1rem;
}
</style>
