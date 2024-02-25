import {createApp} from 'vue'
import './style.css'
import {createPinia} from 'pinia'
import App from './App.vue'
import router from './router'
import storeInstance from './stores/store.js';
// import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import 'element-plus/theme-chalk/index.css'
import 'element-plus/theme-chalk/dark/css-vars.css'
import SvgIcon from '@jamescoyle/vue-icon'

const app = createApp(App)

app.use(router)
// app.use(Antd)
// app.use(ElementPlus)
app.use(storeInstance)
app.component('SvgIcon', SvgIcon);
app.mount('#app')
