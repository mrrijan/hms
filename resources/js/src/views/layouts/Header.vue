<script setup>
import {useRoute, useRouter} from "vue-router";
import getLogout from '../../services/auth/getLogout.js';
import {computed} from "vue";
import {User, UserFilled ,FullScreen} from "@element-plus/icons-vue";
import {useFullscreen} from "@vueuse/core";
import { mdiFullscreen ,mdiFullscreenExit} from '@mdi/js';

const {logout} = getLogout();
const route = useRoute();
const router = useRouter();
const {toggle , isFullscreen} = useFullscreen();

const handleLogout = () => {
    logout().then(() => {
        router.push({name : 'login'});
        window.location.href = '/login';
    }).catch((err) => {
        console.log(err);
    })
}

const breadcrumbs = computed(() => {
    const matchedRoutes = route.matched;
    return matchedRoutes.map((matchedRoute) => ({
        to: matchedRoute.path, label: matchedRoute.meta.breadcrumb || 'unknown'
    }));
})
const toggleFullscreen = ()=>{
    toggle();
}
const getFullScreenIcon = ()=> isFullscreen.value ?mdiFullscreenExit : mdiFullscreen;
</script>

<template>
    <el-page-header @back="$router.back()">
        <template #breadcrumb>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item v-for="crumb in breadcrumbs" :key="crumb.to" :to="{ path: crumb.to }">
                    {{ crumb.label.label }}
                </el-breadcrumb-item>
            </el-breadcrumb>
        </template>
        <template #content>
            <span class="text-large font-600 mr-3">{{ route.meta.title }} </span>
        </template>
        <template #extra>
            <div class="flex items-center">
            <el-button style="margin-right: 1;border: none;" link size="small" class="header-extra"
                       @click="toggleFullscreen">
                <svg-icon type="mdi" size="22" :path="getFullScreenIcon()"></svg-icon>
            </el-button>
            <el-dropdown>
                    <span class="el-dropdown-link">
                      <el-icon class="el-icon--right">
                        <UserFilled/>
                      </el-icon>
                     </span>
                    <template #dropdown>
                        <el-dropdown-menu>
                            <el-dropdown-item @click="handleLogout">
                                    Logout
                            </el-dropdown-item>
                        </el-dropdown-menu>
                    </template>
            </el-dropdown>
            </div>
        </template>
    </el-page-header>
</template>

<style scoped>
.el-dropdown-link{
    cursor: pointer;
}
.el-page-header {
    border-bottom: solid 1px var(--el-menu-border-color);
    padding-bottom: 10px;
}
</style>
