<script setup>
import {ref} from "vue";
import {useDashboardStore} from "../../stores/modules/dashboard.js";
import {
  AppstoreOutlined, BarChartOutlined,
  CloudOutlined, MenuFoldOutlined,
  MenuUnfoldOutlined, ShopOutlined, TeamOutlined, UploadOutlined,
  UserOutlined,
  VideoCameraOutlined
} from "@ant-design/icons-vue";

const dashboardStore = useDashboardStore()
const selectedKeys = ref(['4']);

</script>

<template>
  <a-layout-sider v-model:collapsed="dashboardStore.isCollapsed" :trigger="null" collapsible
                  :style="{ overflow: 'auto', height: '100vh', position: 'fixed', left: 0, top: 0, bottom: 0 , paddingTop : '20px' }"
  >
    <menu-unfold-outlined
        v-if="dashboardStore.isCollapsed"
        class="trigger color-text width-full"
        @click="dashboardStore.handleCollapsed"
    />
    <menu-fold-outlined v-else class="trigger color-text width-auto" @click="dashboardStore.handleCollapsed"/>
    <div class="logo"/>
    <a-menu :style="{marginTop : '24px'}" v-model:selectedKeys="selectedKeys" theme="dark" mode="inline">
      <a-menu-item key="1">
        <user-outlined/>
        <router-link :to="{name : 'customers'}">Customer</router-link>
      </a-menu-item>
      <a-menu-item key="2">
        <video-camera-outlined/>
        <router-link :to="{name : 'rooms'}">Room</router-link>
      </a-menu-item>
      <a-menu-item key="3">
        <upload-outlined/>
          <router-link :to="{name : 'reservations'}">Reservation</router-link>
      </a-menu-item>
      <a-menu-item key="4">
        <bar-chart-outlined/>
          <router-link :to="{name : 'payments'}">Payment</router-link>
      </a-menu-item>
      <a-menu-item key="5">
        <cloud-outlined/>
          <router-link :to="{name : 'staffs'}">Staff</router-link>
      </a-menu-item>
    </a-menu>
  </a-layout-sider>
</template>

<style scoped>

.trigger {
  font-size: 18px;
  line-height: 64px;
  padding: 0 24px;
  cursor: pointer;
  transition: color .3s;
}

.color-text {
  color: white;
}

.width-full {
  width: 100%;
  transition-delay: 0.3s;
}

.width-auto {
  width: fit-content;
}
</style>
