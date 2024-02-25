<script setup>
import {useRouter} from "vue-router";
const router = useRouter();
</script>

<template>
    <div class="text-center">
        <el-text>Sorry the page you are looking for doesnot exist</el-text>
    </div>
    <div class="center">
    <el-button type="primary" @click="router.push({name : 'customers'})" style="margin-top: 15px" size="small">Go Home</el-button>
    </div>
</template>

<style scoped>
.text-center{
    text-align: center;
}
.center{
    width : 100px;
    display: block;
    margin: auto;
}
</style>
