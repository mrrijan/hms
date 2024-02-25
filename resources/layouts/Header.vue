<script setup>
import {h, ref} from "vue";
import {
  BellOutlined,
  BulbFilled,
  BulbOutlined,
  ClockCircleOutlined, FullscreenExitOutlined, FullscreenOutlined,
  SearchOutlined,
  UserOutlined
} from "@ant-design/icons-vue";
import {useColorMode, useFullscreen} from "@vueuse/core";
import{useRouter , useRoute} from "vue-router";

const router = useRouter();
const route = useRoute();
import {useDashboardStore} from "../../stores/modules/dashboard.js";

const {toggle, isFullscreen} = useFullscreen()
const dashboardStore = useDashboardStore()
const getFullscreenToggleIcon = () => isFullscreen.value ? h(FullscreenExitOutlined) : h(FullscreenOutlined)

</script>

<template>
  <a-layout-header
      :style="{top:0, background : '#fff', position: 'fixed',zIndex: 1, width: '-webkit-fill-available',height: 'auto', padding: 0}">
    <div>
      <a-page-header :title="route.meta.title" @back="() => $router.back(-1)">

        <template #extra>
          <a-tooltip title="Full Screen">
            <a-button shape="circle" :icon="getFullscreenToggleIcon()" @click="toggle"/>
          </a-tooltip>
          <a-tooltip title="User">
            <a-button shape="circle" :icon="h(UserOutlined)"/>
          </a-tooltip>
        </template>
      </a-page-header>
    </div>
  </a-layout-header>

</template>

<style scoped>

</style>
