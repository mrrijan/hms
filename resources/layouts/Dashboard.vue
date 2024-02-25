<script setup>
import {useDashboardStore} from "../../stores/modules/dashboard.js";

import SideBar from "./SideBar.vue";
import Header from "./Header.vue";
import Footer from "./Footer.vue";

const dashboardStore = useDashboardStore()
</script>

<template>
  <a-layout has-sider>
    <SideBar/>
    <a-layout class="collapsible-body" :class="{collapsed: dashboardStore.isCollapsed}">
      <Header/>
      <a-layout-content :style="{ margin: '75px 16px 0', overflow: 'initial'}">
        <div :style="{ padding: '24px',  textAlign: 'left' }">
          <RouterView/>
        </div>
      </a-layout-content>
      <Footer/>
    </a-layout>
  </a-layout>
</template>

<style scoped>
.collapsible-body {
  margin-left: 200px;
  transition-duration: 0.2s;
}

.collapsible-body.collapsed {
  margin-left: 80px;
  transition-duration: 0.2s;
}
</style>
