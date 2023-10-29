<template>
    <div class="relative">
        <Header />
        <div class="h-[52px]"></div>

        <!-- bread-crumb -->
        <div class="py-1 px-3">
            <span class="text-[#7f9799] text-xs"> Beranda > Motor </span>
        </div>

        <PhotoProduct :list="produk.produk_foto" />

        <!-- product-title -->
        <div class="bg-white p-4">
            <div class="flex justify-between items-center mb-1 mt-2">
                <span class="font-bold text-xl">Rp {{ ribuan(produk.harga) }}</span>
                <div class="flex items-center gap-4">
                    <div class="i-share"></div>
                    <div class="i-love"></div>
                </div>
            </div>
            <p class="text-sm">{{ produk.produk_judul }}</p>
            <div class="h-[1px] w-full bg-slate-300 mt-5"></div>
            <div class="flex justify-between mt-2 text-subTitle text-sm">
                <p class="text-xs">Wedung, Demak, Jawa Tengah</p>
                <p class="text-xs">Hari ini</p>
            </div>
        </div>

        <!-- produk-detail -->
        <div class="bg-white p-4 mt-2">
            <h1 class="text-xl font-bold mb-4">Detail</h1>
            <div class="grid grid-cols-2">
                <p class="text-sm h-7 text-subTitle">Merek</p>
                <p class="text-sm h-7">{{ produk.merek }}</p>

                <p class="text-sm h-7 text-subTitle">Model</p>
                <p class="text-sm h-7">{{ produk.model }}</p>

                <p class="text-sm h-7 text-subTitle">Tahun</p>
                <p class="h-7">{{ produk.tahun_keluaran }}</p>

                <p class="text-sm h-7 text-subTitle">Jarak tempuh</p>
                <p class="text-sm h-7">{{ produk.jarak_tempuh }}</p>

                <p class="text-sm h-7 text-subTitle">Tipe penjual</p>
                <p class="text-sm h-7">Individu</p>
            </div>
        </div>

        <!-- product-description -->
        <div class="bg-white p-4 mt-2">
            <h1 class="text-xl font-bold mb-4">Deskripsi</h1>
            <p>{{ produk.produk_deskripsi }}</p>
        </div>

        <!-- product-seller -->
        <div @click="goToSellerProfile" class="bg-white p-4 mt-2 flex justify-between items-center">
            <div class="w-full flex gap-4 items-center">
                <div class="rounded-full w-16 h-16 overflow-hidden">
                    <img
                        class="w-full h-full object-cover"
                        :src="'/api/user/download_photo/'+produk.username_pemasang"
                        alt=""
                    />
                </div>
                <span class="font-bold text-xl">{{
                    produk.produk_pemasang
                }}</span>
            </div>
            <div class="i-arrow-right"></div>
        </div>

        <!-- product user -->
        <div
            v-if="username === produk.username_pemasang"
            class="w-full bg-white p-4 flex flex-col gap-1"
        >
            <button @click="editProduct" class="w-full h-12 bg-buy-button rounded-md text-white font-bold">Edit</button>
            <button @click="deleteProduct" class="w-full h-12 border-2 border-black rounded-md font-bold">Hapus</button>

        </div>
        <!-- product-id -->
        <div v-else class="bg-white p-4 mt-2 flex justify-between items-center">
            <span class="font-bold text-sm">ID IKLAN {{ produk.produk_id }}</span>
            <span class="font-bold text-sm">LAPORKAN IKLAN INI</span>
        </div>

        <BuyButton v-if="username !== produk.username_pemasang" />
    </div>
    <Footer />
</template>

<script>
import Header from "../components/Header.vue";
import PhotoProduct from "../components/product/PhotoProduct.vue";
import BuyButton from "../components/product/BuyButton.vue";
import Footer from "../components/Footer.vue";

import axios from "axios";
import Swal from "sweetalert2";

export default {
    name: "product-detail",
    data() {
        return {
            produk: {},
            username: ""
        };
    },
    components: {
        Header,
        PhotoProduct,
        BuyButton,
        Footer,
    },
    methods: {
        deleteProduct() {
            axios.delete("/api/produk/"+this.produk.produk_id)
            .then((res)=>{
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: res.data.message,
                    timer: 2000,
                    showConfirmButton: false
                })
                .then(()=>this.$router.push("/app"))
            })
            .catch((err)=>{
                console.log(err);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Terjadi kesalahan",
                    timer: 2000,
                    showConfirmButton: false
                })
            })
        },
        editProduct() {
            this.$router.push("/app/edit/"+this.produk.produk_id)
        },
        goToSellerProfile() {
            if(this.produk.username_pemasang === this.username) {
                this.$router.push("/app/profile")
            } else {
                this.$router.push("/app/profile/"+this.produk.username_pemasang)
            }
        },
        ribuan(price) {
            return price?.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    },
    mounted() {
        axios.get("/api/produk/detail/" + this.$route.params.id).then((res) => {
            console.log(res.data.data);
            this.produk = res.data.data;
        });

        axios.get("/api/user/data").then((res) => {
                console.log(res.data.user_data.username);
                this.username = res.data.user_data.username
            });

    },
};
</script>
