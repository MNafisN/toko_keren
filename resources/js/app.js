import './bootstrap';
import {createApp} from 'vue'
import vue from './app.vue'
import router from './router'
import store from './store'
import '../css/icon.css'
import axios from './services/axios';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

createApp(vue)
.use(router)
.use(store)
.use(VueSweetalert2)
.mount('#app')