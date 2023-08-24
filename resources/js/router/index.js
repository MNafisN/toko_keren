import {createRouter, createWebHistory} from 'vue-router'
import Home from '../pages/Home.vue'
import Login from '../pages/Login.vue'
import Register from '../pages/Register.vue'
import Product from '../pages/Product.vue'
import EditProfile from '../pages/EditProfile.vue'
import Profile from '../pages/Profile.vue'
import ListProduct from '../pages/ListProduct.vue'
import PostCategory from '../pages/PostCategory.vue'
import PostProduct from '../pages/PostProduct.vue'

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
        path: "/app/product/:id",
        component: Product
    },
    {
        path: "/app/editProfile",
        component: EditProfile
    },
    {
        path: "/app/profile",
        component: Profile
    },
    {
        path: "/app/search/:query",
        component: ListProduct
    },
    {
        path: "/app/category/:query",
        component: ListProduct
    },
    {
        path: "/app/post",
        component: PostCategory
    },
    {
        path: "/app/post/:category",
        component: PostProduct
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router