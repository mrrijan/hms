<script setup>

import SideBar from "./SideBar.vue";
import {useSidebarCollapseStore} from '../../stores/modules/sidebarCollapse.js';
import Header from "./Header.vue";
import Footer from "./Footer.vue";

const store = useSidebarCollapseStore();
</script>

<template>
    <div class="common-layout">
        <el-container style="max-height: 100vh">
            <el-aside :class="{collapsed : store.isCollapsed}" style="position: fixed; display: block; z-index: 2">
                <SideBar/>
            </el-aside>
            <el-container :class="{sidebar_collapsed: store.isCollapsed}" class="main-container">
                <el-header>
                    <Header/>
                </el-header>
                <el-main>
                    <el-scrollbar height="100%">
                        <el-col :span="24">
                            <router-view/>
                        </el-col>
                    </el-scrollbar>
                </el-main>
            </el-container>
        </el-container>
    </div>
</template>

<style scoped>
.el-main {
    padding-left: 2rem;
}

.el-aside {
    width: auto;
    border-right: solid 1px var(--el-menu-border-color);
    min-height: 100vh;
}

</style>
