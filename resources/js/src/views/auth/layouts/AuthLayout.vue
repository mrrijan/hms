<script setup>

import {ArrowLeft, Bell, FullScreen, Moon, Sunny, User} from "@element-plus/icons-vue";
import {onBeforeMount, ref} from "vue";
import {useThemeSwitchStore} from "../../../stores/modules/themeSwitch.js";
const themeSwitchStore = useThemeSwitchStore();
let themeValue = ref('light');
const themePreset = () =>themeValue = ref(themeSwitchStore.theme === 'light')
onBeforeMount(()=>{
  themePreset()
})
</script>

<template>
  <div class="common-layout">
    <el-row class="row-bg" justify="center">
      <router-view></router-view>
    </el-row>
  </div>
</template>

<style scoped>
    .row-bg{
        margin-top: 120px;
    }
</style>
