<template>
    <div class="relative">
        <Header />
        <div class="h-[52px]"></div>

        <!-- bread-crumb -->
        <div class="py-1 px-3">
            <span class="text-[#7f9799] text-xs"> Beranda > Motor </span>
        </div>

        <PhotoProduct />

        <!-- product-title -->
        <div class="bg-white p-4">
            <div class="flex justify-between items-center mb-1 mt-2">
                <span class="font-bold text-xl">Rp {{ produk.harga }}</span>
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
            <h1 class="text-xl font-bold mb-4">Detail</h1>
            <p>{{ produk.produk_deskripsi }}</p>
        </div>

        <!-- product-seller -->
        <div class="bg-white p-4 mt-2 flex justify-between items-center">
            <div class="w-full flex gap-4 items-center">
                <div class="rounded-full w-16 h-16 overflow-hidden">
                    <img
                        class="w-full h-full object-cover"
                        src="/assets/avatar.png"
                        alt=""
                    />
                </div>
                <span class="font-bold text-xl">{{
                    produk.produk_pemasang
                }}</span>
            </div>
            <div class="i-arrow-right"></div>
        </div>

        <!-- product-id -->
        <div class="bg-white p-4 mt-2 flex justify-between items-center">
            <span class="font-bold text-sm">ID IKLAN {{ produk.produk_id }}</span>
            <span class="font-bold text-sm">LAPORKAN IKLAN INI</span>
        </div>

        <BuyButton />
    </div>
    <Footer />
</template>

<script>
import PhotoProduct from "../components/product/PhotoProduct.vue";
import BuyButton from "../components/product/BuyButton.vue";
import Footer from "../components/Footer.vue";

import axios from "axios";

export default {
    name: "product-detail",
    data() {
        return {
            produk: {},
        };
    },
    components: {
        Header,
        Breadcrumb,
        PhotoProduct,
        ProductTitle,
        ProductDetail,
        ProductDescription,
        ProductSeller,
        ProductId,
        BuyButton,
        Footer,
    },
    mounted() {
        axios.get("/api/produk/detail/" + this.$route.params.id).then((res) => {
            console.log(res.data.data);
            this.produk = res.data.data;
        });
    },
};
</script>
