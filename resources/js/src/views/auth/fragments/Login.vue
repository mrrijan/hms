<script setup>
import {reactive} from "vue";
import {Discount} from "@element-plus/icons-vue";
import postLogin from '../../../services/auth/postLogin.js';
import {useRouter} from "vue-router";
import {ref} from "vue";

const errors = ref('');
const router = useRouter();
const {login} = postLogin();
const form = reactive({
  email: '',
  password: '',
  remember: false,
})

const handleLogin = ()=>{
    const credentials = {
        email : form.email,
        password : form.password
    };
    login(credentials).then(()=>{
        router.push({name : 'customers'});
    }).catch((err) => {
        console.log(err.response.data.errors.message);
        errors.value = err.response.data.errors.message;
    })
}
</script>

<template>
  <el-col :lg="8" :md="10" :sm="12">
    <el-card class="box-card">
      <el-form :model="form" label-width="120px">
        <el-form-item label="Email" required>
          <el-input v-model="form.email" clearable/>
        </el-form-item>
        <el-form-item label="Password" required>
          <el-input type="password" v-model="form.password" show-password clearable/>
        </el-form-item>
        <el-form-item label="Remember Me">
          <el-switch v-model="form.remember" size="small"/>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="handleLogin">Login</el-button>
        </el-form-item>
        <el-text style="text-align: center" type="danger">{{errors}}</el-text>
      </el-form>
    </el-card>
  </el-col>
</template>

<style scoped>

</style>
