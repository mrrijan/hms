<script setup>
import {useRoute, useRouter} from "vue-router";
import getLogout from '../../services/auth/getLogout.js';
import {computed, ref} from "vue";
import {User, UserFilled, FullScreen} from "@element-plus/icons-vue";
import {useThemeSwitchStore} from "../../stores/modules/themeSwitch.js";
import {useFullscreen} from "@vueuse/core";
import {Sunny, Moon, ArrowLeft} from "@element-plus/icons-vue";
import {mdiFullscreen, mdiFullscreenExit} from '@mdi/js';

let themeValue = ref('light');
const {logout} = getLogout();
const route = useRoute();
const router = useRouter();
const {toggle, isFullscreen} = useFullscreen();

const themeSwitchStore = useThemeSwitchStore();
const themeSwitch = val => {
    if (val) {
        themeSwitchStore.setTheme('light')
        themeValue = ref(true);
        document.documentElement.classList.add('light')
        document.documentElement.classList.remove('dark')
    } else {
        document.documentElement.classList.add('dark')
        document.documentElement.classList.remove('light')
        themeSwitchStore.setTheme('dark')
        themeValue = ref(false);
    }
}

const handleLogout = () => {
    logout().then(() => {
        router.push({name: 'login'});
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
const toggleFullscreen = () => {
    toggle();
}
const getFullScreenIcon = () => isFullscreen.value ? mdiFullscreenExit : mdiFullscreen;
</script>

<template>
    <el-page-header :icon="null" @back="$router.back()">
        <template #breadcrumb>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item v-for="crumb in breadcrumbs" :key="crumb.to" :to="{ path: crumb.to }">
                    {{ crumb.label.label }}
                </el-breadcrumb-item>
            </el-breadcrumb>
        </template>
        <template #title>
            <el-icon>
                <ArrowLeft/>
            </el-icon>
        </template>
        <template #content>
            <span class="text-large font-600 mr-3">{{ route.meta.title }} </span>
        </template>
        <template #extra>
            <div class="flex items-center">
                <el-switch
                    size="small"
                    v-model=themeValue
                    class="mt-2 header-extra"
                    :style="{marginRight: '10px'}"
                    inline-prompt
                    :active-icon="Sunny"
                    :inactive-icon="Moon"
                    @change=themeSwitch
                />
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
.el-dropdown-link {
    cursor: pointer;
}

.el-page-header {
    border-bottom: solid 1px var(--el-menu-border-color);
    padding: 5px 0px;
}

.header-extra {
    margin-left: 0.5rem !important;
    margin-right: 0.5rem !important;
}

.el-breadcrumb {
    border-bottom: solid 1px var(--el-menu-border-color);
    padding-bottom: 0.5rem;
    padding-left: 1rem;
}
</style>
