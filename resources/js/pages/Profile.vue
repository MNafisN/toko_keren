<template>
    <Header />
    <div class="h-[52px]"></div>
    <div class="p-4 bg-white">
        <div class="container mx-auto flex gap-4 items-center py-4">
            <div
                class="w-[60px] h-[60px] rounded-full overflow-hidden bg-blue-500 flex justify-center items-center"
            >
                <img
                    v-if="userData.profile_picture"
                    :src="'/api/user/download_photo/' + userData.username"
                    alt="photo profile"
                />
                <span v-else class="text-white text-3xl">I</span>
            </div>
            <span class="font-bold text-xl">{{ userData.username }}</span>
        </div>
        <div class="container mx-auto">
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
        <div class="container mx-auto my-4">
            <p class="text-xs font-bold">Pengguna terverifikasi dengan</p>
            <div class="flex gap-2 mt-2">
                <div class="i-verif-email"></div>
                <div class="i-verif-phone"></div>
            </div>
        </div>
        <div class="container mx-auto flex flex-col md:flex-row md:gap-4">
            <button
                v-if="userData.username === getUsername"
                @click="goToEditProfile"
                class="w-full h-11 rounded-md bg-buy-button flex justify-center items-center gap-1"
            >
            <div class="i-edit"></div>
            <span class="text-white font-bold">Edit Profile</span>
            </button>
            <div class="mt-5 mb-4 flex justify-center items-center md:border-2 md:border-buy-button md:w-full md:h-11 md:m-0 md:rounded-md">
                <span class="font-bold text-sm">Bagikan Profil</span>
            </div>
        </div>
    </div>
    <div class="bg-white">
        <div
            v-if="list.length !== 0"
            class="container mx-auto w-full bg-white py-2 mt-3 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4"
        >
            <ProductCard v-for="item in list" page="home" :produk="item" />
        </div>
        <div v-else class="w-full bg-white mt-3 py-8 flex flex-col items-center">
            <div class="w-[200px] h-[200px] mb-4">
                <img
                    class="w-full h-full object-contain"
                    src="/assets/no-publications.webp"
                    alt="tidak ada iklan"
                />
            </div>
            <p class="font-bold">Anda belum memasang iklan</p>
            <p class="w-3/5 text-subTitle text-center mb-6">
                Jual barang yang sudah tidak terpakai
            </p>
            <button class="px-4 h-12 bg-buy-button rounded-md font-bold text-white">
                Pasang iklan
            </button>
        </div>
    </div>
    <Footer />
</template>

<script>
import Header from "../components/Header.vue";
import Footer from "../components/Footer.vue";
import ProductCard from "../components/ProductCard.vue";
import axios from "axios";

export default {
    name: "profile-page",
    data() {
        return {
            list: [],
            userData: {},
        };
    },
    components: {
        Header,
        Footer,
        ProductCard
    },
    computed: {
        getUsername() {
            return this.$store.getters.getUsername
        }
    },
    methods: {
        goToEditProfile() {
            this.$router.push("/app/editProfile");
        },
    },
    mounted() {
        const getList = ()=> {
            axios.get("/api/produk/user/"+this.userData.username)
            .then((res)=> {
                console.log(res.data)
                this.list = res.data.data
            })
            .catch((err) => console.log(err))
        }
        if (this.$route.params.username) {
            axios.get("/api/user/data/" + this.$route.params.username)
            .then((res) => {
                console.log(res.data);
                this.userData = res.data.user_data;
                getList()
            })
            .catch((err) => {
                console.log(err);
            })
    } else {
        axios.get("/api/user/data")
        .then((res)=> {
            console.log(res.data);
            this.userData = res.data.user_data
            getList()
        })
        .catch((err) => {
                if (err.response.status === 401) this.$router.push("/app/login")
            })
        }
    },
};
</script>
