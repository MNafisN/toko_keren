<template>
    <Header />
    <div class="h-[52px]"></div>
    <div class="p-4 bg-white">
        <div class="flex gap-4 items-center py-4">
            <div class="w-[60px] h-[60px] rounded-full overflow-hidden bg-blue-500 flex justify-center items-center">
                <img v-if="infoUser.profile_picture" src="/api/user/download_photo/'" alt="">
                <span v-else class="text-white text-3xl">I</span>
            </div>
            <span class="font-bold text-xl">{{ infoUser.username }}</span>
        </div>
        <div>
            <div class="flex gap-2 items-center">
                <div class="i-calender"></div>
                <span class="text-xs">Anggota sejak Hari ini</span>
            </div>
            <div class="flex pt-4 gap-2 items-center">
                <div class="i-user"></div>
                <span class="text-xs">0 Followers</span>
                <div class="w-px h-3 bg-subTitle"></div>
                <span class="text-xs">0 Followings</span>
            </div>
        </div>
        <div class="my-4">
            <p class="text-xs font-bold">Pengguna terverifikasi dengan</p>
            <div class="flex gap-2 mt-2">
                <div class="i-verif-email"></div>
                <div class="i-verif-phone"></div>
            </div>
        </div>
        <button @click="goToEditProfile" class="w-full h-11 rounded-md bg-buy-button flex justify-center items-center gap-1">
            <div class="i-edit"></div>
            <span class="text-white font-bold">Edit Profile</span>
        </button>
        <div class="mt-8 mb-4 flex justify-center">
            <span class="font-bold text-sm">Bagikan Profil</span>
        </div>
    </div>
    <div v-if="list.length !== 0" class="w-full bg-white p-2 mt-3 grid grid-cols-2 gap-3 sm:grid-cols-3">
        <ProductCard v-for="item in list" page="home" :produk="item" />
    </div>
    <div v-else class="w-full bg-white mt-3 py-8 flex flex-col items-center">
        <div class="w-[200px] h-[200px] mb-4">
            <img class="w-full h-full object-contain" src="/assets/no-publications.webp" alt="tidak ada iklan">
        </div>
        <p class="font-bold">Anda belum memasang iklan</p>
        <p class="w-3/5 text-subTitle text-center mb-6">Jual barang yang sudah tidak terpakai</p>
        <button class="px-4 h-12 bg-buy-button rounded-md font-bold text-white">Pasang iklan</button>
    </div>
    <Footer />
</template>

<script>
import Header from '../components/Header.vue';
import Footer from '../components/Footer.vue';
import ProductCard from '../components/ProductCard.vue';
import axios from 'axios';

export default {
    name: 'profile-page',
    data() {
        return {
            list: []
        }
    },
    components: {
        Header,
        Footer,
        ProductCard
    },
    computed: {
        infoUser() {
            return this.$store.getters.getUserData
        }
    },
    methods: {
        goToEditProfile() {
            this.$router.push('/app/editProfile')
        }
    },
    mounted() {
        axios
            .get('/api/produk/user/me')
            .then((res)=>{
                console.log(res.data.data)
                this.list = res.data.data
            })
            .catch((err)=>console.log(err))
    }
}
</script>