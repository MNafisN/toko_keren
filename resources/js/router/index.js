import {createRouter, createWebHistory} from 'vue-router'
import Home from '../pages/Home.vue'
import Login from '../pages/Login.vue'
import Register from '../pages/Register.vue'
import Product from '../pages/Product.vue'

const routes = [
    {
        path: "/app/login",
        component: Login
    },
    {
        path: "/app/register",
        component: Register
    },
    {
        path: "/app",
        component: Home
    },
    {
        path: "/app/product",
        component: Product
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router