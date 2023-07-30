import './bootstrap';
import {createApp} from 'vue'
import vue from './app.vue'
import router from './router'
import store from './store'
import '../css/icon.css'

createApp(vue)
.use(router)
.use(store)
.mount('#app')